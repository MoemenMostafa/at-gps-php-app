// JavaScript Document
function printContent(id, title) {
    title = typeof title !== 'undefined' ? title : "Reprot";
    str = document.getElementById(id).innerHTML;
	var styles = $("#phpexcel").html();
    newwin = window.open('', 'printwin', 'left=50,top=50,width=900,height=600');
    newwin.document.write('<HTML>\n<HEAD>\n');
    newwin.document.write('<link rel="stylesheet" type="text/css" href="http://www.at-gps.com/css/screen.css">');
    newwin.document.write('<TITLE>'+title+'</TITLE>\n');
    newwin.document.write('<script>\n');
    newwin.document.write('function chkstate(){\n');
    newwin.document.write('if(document.readyState=="complete"){\n');
    newwin.document.write('window.close()\n');
    newwin.document.write('}\n');
    newwin.document.write('else{\n');
    newwin.document.write('setTimeout("chkstate()",2000)\n');
    newwin.document.write('}\n');
    newwin.document.write('}\n');
    newwin.document.write('function print_win(){\n');
    newwin.document.write('window.print();\n');
    newwin.document.write('chkstate();\n');
    newwin.document.write('}\n');
    newwin.document.write('<\/script>\n');
    newwin.document.write('</HEAD>\n');
    newwin.document.write('<BODY onload="print_win()">\n');
	newwin.document.write('<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">\n');
    newwin.document.write(str);
	newwin.document.write('</TABLE>\n');
    newwin.document.write('<style>'+styles+'</style>');
    newwin.document.write('</BODY>\n');
    newwin.document.write('</HTML>\n');
    newwin.document.close();
}



