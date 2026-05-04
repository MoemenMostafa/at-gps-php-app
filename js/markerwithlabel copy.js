/**
 * This constructor creates a label and associates it with a marker.
 * It is for the private use of the MarkerWithLabel class.
 */
class MarkerLabel_ extends google.maps.OverlayView {
  constructor(marker, options) {
    super();
    this.marker_ = marker;

    this.labelDiv_ = document.createElement("div");
    this.labelDiv_.style.cssText = "position: absolute; overflow: hidden;";

    // Apply label content and styles
    if (options.labelContent) {
      this.labelDiv_.innerHTML = options.labelContent;
    }
    if (options.labelClass) {
      this.labelDiv_.className = options.labelClass;
    }
    if (options.labelStyle) {
      Object.assign(this.labelDiv_.style, options.labelStyle);
    }

    // Set up the DIV for handling mouse events in the label
    this.eventDiv_ = document.createElement("div");
    this.eventDiv_.style.cssText = this.labelDiv_.style.cssText;

    // Get the DIV for the "X" to be displayed when the marker is raised
    if (options.crossImage) {
      this.crossDiv_ = MarkerLabel_.getSharedCross(options.crossImage);
    }

    // Bind to the marker's map immediately
    this.setMap(marker.getMap());
  }

  /** 
   * Gets the DIV for the cross used when dragging a marker when the
   * cross-on-drag feature is enabled.
   * @param {string} crossURL The URL of the cross image.
   */
  static getSharedCross(crossURL) {
    let div;
    if (typeof MarkerLabel_.getSharedCross.crossDiv === 'undefined') {
      div = document.createElement('div');
      div.style.cssText = 'position: absolute; z-index: 1000002; display: none;';
      // Hopefully Google never changes the standard "X" attributes:
      div.style.marginLeft = '-8px';
      div.style.marginTop = '-9px';
      div.style.width = '17px';
      div.style.height = '19px';
      div.style.cursor = 'pointer';
      div.style.userSelect = 'none';
      div.style.backgroundImage = 'url(' + crossURL + ')';
      MarkerLabel_.getSharedCross.crossDiv = div;
    }
    return MarkerLabel_.getSharedCross.crossDiv;
  }

  onAdd() {
    const pane = this.getPanes().overlayImage;
    pane.appendChild(this.labelDiv_);
    pane.appendChild(this.eventDiv_);
  }

  onRemove() {
    this.labelDiv_.parentNode.removeChild(this.labelDiv_);
    this.eventDiv_.parentNode.removeChild(this.eventDiv_);
  }

  draw() {
    const projection = this.getProjection();
    const position = projection.fromLatLngToDivPixel(this.marker_.getPosition());

    const div = this.labelDiv_;
    div.style.left = position.x + 'px';
    div.style.top = position.y + 'px';
    div.style.display = 'block';

    const eventDiv = this.eventDiv_;
    eventDiv.style.left = div.style.left;
    eventDiv.style.top = div.style.top;
    eventDiv.style.display = div.style.display;
  }
}

class MarkerWithLabel extends google.maps.Marker {
  constructor(opt_options = {}) {
    // Set default options
    const options = {
      labelContent: "",
      labelAnchor: new google.maps.Point(0, 0),
      labelClass: "markerLabels",
      labelStyle: {},
      labelInBackground: false,
      labelVisible: true,
      crossOnDrag: true,
      clickable: true,
      draggable: false,
      optimized: false,
      crossImage: "//maps.gstatic.com/intl/en_us/mapfiles/drag_cross_67_16.png",
      ...opt_options
    };

    // Force optimized to false as it's not supported
    options.optimized = false;

    // Call parent constructor
    super(options);

    // Create the label immediately
    this.label = new MarkerLabel_(this, options);
  }

  /**
   * Overrides the standard Marker setMap function.
   */
  setMap(theMap) {
    super.setMap(theMap);
    
    if (this.label) {
      this.label.setMap(theMap);
    }
  }
} 