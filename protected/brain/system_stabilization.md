# ATGPS System Stabilization & Maintenance Knowledge Base

## Core Architecture Insights
*   **Tracking Tables**: GPS points are stored in individual tables per vehicle: `vehicle_points_{ID}`. These tables are indexed on `gps_datetime`.
*   **Reporting Engine**: The system uses `CActiveDataProvider` (or `CArrayDataProvider` for dynamic reports) and passes data to views that often interact with `PHPReport` (XLSX templates).

## Critical Technical Solutions

### 1. Robust Date Handling
Legacy code used `DateTime` constructor on raw numeric strings (e.g., `20260501000000`), which frequently failed. 
**Solution**: Use `DateTime::createFromFormat('YmdHis', $string)` to ensure reliable parsing across different PHP environments and input formats.

### 2. Reviving "Dead" Reports
Reports like "Overspeeding All" relied on `alert_overspeed`, a summary table that stopped receiving data in 2016. 
**Solution**: Rebuild the report logic to dynamically aggregate data from the `vehicle_points_X` tracking tables on the fly. This ensures the report is always live and accurate.

### 3. SQL Robustness
*   **Input Validation**: Always cast or verify `vehicle_id` before querying `vehicle_points_X` to avoid SQL injection or syntax errors when "All Vehicles" is selected.
*   **Table Existence**: Use `Yii::app()->db->schema->getTable($tableName)` to verify tracking tables exist before attempting a `SELECT` or `DROP`.

### 4. Distance Calculation
Standardized distance formula for latitude/longitude points:
```php
private function calculateDistance($lat1, $lng1, $lat2, $lng2) {
    $pi80 = M_PI / 180;
    $lat1 *= $pi80; $lng1 *= $pi80; $lat2 *= $pi80; $lng2 *= $pi80;
    $r = 6372.797; // Mean radius of Earth in km
    $dlat = $lat2 - $lat1; $dlng = $lng2 - $lng1;
    $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlng / 2) ** 2;
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $r * $c; // Returns KM
}
```

## Maintenance Best Practices
*   **Cleanup**: When deleting a vehicle, always drop its associated `vehicle_points_X` table to prevent database bloat.
*   **Log Monitoring**: Monitor `protected/runtime/application.log` for silent failures in the background cron scripts (`cron/*.php`).
