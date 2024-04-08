<?php
    set_time_limit(0);
    require_once "Database.php";
    require_once "stmtPrepare.php";

    $vehicleJson = "Vehicles.json";
    $vehicleContent = file_get_contents($vehicleJson);
    $vehicles = json_decode($vehicleContent, true);

    $gpsJson = "Gps.json";
    $gpsContent = file_get_contents($gpsJson);
    $gps = json_decode($gpsContent, true);

    session_start();

    foreach ($gps as $entry) {
        $stmt = $db->conn->prepare("SELECT COUNT(*) FROM gps WHERE title = :title");
        $stmt->bindParam(':title', $entry["name"]);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        if ($count > 0) {
            echo "Skipped entry with name {$entry['name']}, already exists in the database.\n";
        } else {
        $gpsSQL->execute([
            "_id" => $entry["id"],
            "_title" => $entry["name"],
            "_attribute_b2b" => $entry["attributes"]["B2B"] ?? null,
            "_attribute_firmware" => $entry["attributes"]["firmware"] ?? null,
            "_attribute_guarded" => $entry["attributes"]["guarded"] ?? null,
            "_attribute_alarm" => $entry["attributes"]["alarm"] ?? null,
            "_attribute_lastAlarm" => $entry["attributes"]["lastAlarm"] ?? null,
            "_groupId" => $entry["groupId"] ?? null,
            "_uniqueId" => $entry["uniqueId"] ?? null,
            "_stat" => $entry["status"] ?? null,
            "_lastUpdate" => $entry["lastUpdate"] ?? null,
            "_positionId" => $entry["positionId"] ?? null,
            "_geofenceIds" => $entry["geofenceIds"][0] ?? null,
            "_phone" => $entry["phone"] ?? null,
            "_model" => $entry["model"] ?? null,
            "_contact" => $entry["contact"] ?? null,
            "_category" => $entry["category"] ?? null,
            "_isDisabled" => $entry["disabled"] ?? null,
            "_positions_id" => $entry["positions"]["id"] ?? null,
            "_positions_armed" => $entry["positions"]["attributes"]["armed"] ?? null,
            "_positions_charge" => $entry["positions"]["attributes"]["charge"] ?? null,
            "_positions_ignition" => $entry["positions"]["attributes"]["ignition"] ?? null,
            "_positions_stat" => $entry["positions"]["attributes"]["status"] ?? null,
            "_positions_distance" => $entry["positions"]["attributes"]["distance"] ?? null,
            "_positions_totalDistance" => $entry["positions"]["attributes"]["totalDistance"] ?? null,
            "_positions_motion" => $entry["positions"]["attributes"]["motion"] ?? null,
            "_positions_batteryLevel" => $entry["positions"]["attributes"]["batteryLevel"] ?? null,
            "_positions_hours" => $entry["positions"]["attributes"]["hours"] ?? null,
            "_deviceId" => $entry["positions"]["deviceId"] ?? null,
            "_thisType" => $entry["positions"]["type"] ?? null,
            "_protocol" => $entry["positions"]["protocol"] ?? null,
            "_serverTime" => $entry["positions"]["serverTime"] ?? null,
            "_deviceTime" => $entry["positions"]["deviceTime"] ?? null,
            "_fixTime" => $entry["positions"]["fixTime"] ?? null,
            "_outdated" => $entry["positions"]["outdated"] ?? null,
            "_valid" => $entry["positions"]["valid"] ?? null,
            "_latitude" => $entry["positions"]["latitude"] ?? null,
            "_longitude" => $entry["positions"]["longitude"] ?? null,
            "_altitude" => $entry["positions"]["altitude"] ?? null,
            "_speed" => $entry["positions"]["speed"] ?? null,
            "_course" => $entry["positions"]["course"] ?? null,
            "_thisAddress" => $entry["positions"]["address"] ?? null,
            "_accuracy" => $entry["positions"]["accuracy"] ?? null,
            "_network" => $entry["network"] ?? null
        ]);
    }
    }

    // foreach ($gps as $entry) {
    //     $stmt = $db->conn->prepare("SELECT COUNT(*) FROM gps WHERE title = :title");
    //     $stmt->bindParam(':title', $entry["name"]);
    //     $stmt->execute();
    //     $count = $stmt->fetchColumn();
    
    //     if ($count > 0) {
    //         echo "Skipped entry with name {$entry['name']}, already exists in the database.\n";
    //     } else {
    //     $gpsSQL->execute([
    //         "_id" => $entry["id"],
    //         "_title" => $entry["name"],
    //         "_attribute_b2b" => $entry["attributes"]["B2B"] ?? null,
    //         "_attribute_firmware" => $entry["attributes"]["firmware"] ?? null,
    //         "_attribute_guarded" => $entry["attributes"]["guarded"] ?? null,
    //         "_attribute_alarm" => $entry["attributes"]["alarm"] ?? null,
    //         "_attribute_lastAlarm" => $entry["attributes"]["lastAlarm"] ?? null,
    //         "_groupId" => $entry["groupId"] ?? null,
    //         "_uniqueId" => $entry["uniqueId"] ?? null,
    //         "_stat" => $entry["status"] ?? null,
    //         "_lastUpdate" => $entry["lastUpdate"] ?? null,
    //         "_positionId" => $entry["positionId"] ?? null,
    //         "_geofenceIds" => $entry["geofenceIds"][0] ?? null,
    //         "_phone" => $entry["phone"] ?? null,
    //         "_model" => $entry["model"] ?? null,
    //         "_contact" => $entry["contact"] ?? null,
    //         "_category" => $entry["category"] ?? null,
    //         "_isDisabled" => $entry["disabled"] ?? null,
    //         "_positions_id" => $entry["positions"]["id"] ?? null,
    //         "_positions_armed" => $entry["positions"]["attributes"]["armed"] ?? null,
    //         "_positions_charge" => $entry["positions"]["attributes"]["charge"] ?? null,
    //         "_positions_ignition" => $entry["positions"]["attributes"]["ignition"] ?? null,
    //         "_positions_stat" => $entry["positions"]["attributes"]["status"] ?? null,
    //         "_positions_distance" => $entry["positions"]["attributes"]["distance"] ?? null,
    //         "_positions_totalDistance" => $entry["positions"]["attributes"]["totalDistance"] ?? null,
    //         "_positions_motion" => $entry["positions"]["attributes"]["motion"] ?? null,
    //         "_positions_batteryLevel" => $entry["positions"]["attributes"]["batteryLevel"] ?? null,
    //         "_positions_hours" => $entry["positions"]["attributes"]["hours"] ?? null,
    //         "_deviceId" => $entry["positions"]["deviceId"] ?? null,
    //         "_thisType" => $entry["positions"]["type"] ?? null,
    //         "_protocol" => $entry["positions"]["protocol"] ?? null,
    //         "_serverTime" => $entry["positions"]["serverTime"] ?? null,
    //         "_deviceTime" => $entry["positions"]["deviceTime"] ?? null,
    //         "_fixTime" => $entry["positions"]["fixTime"] ?? null,
    //         "_outdated" => $entry["positions"]["outdated"] ?? null,
    //         "_valid" => $entry["positions"]["valid"] ?? null,
    //         "_latitude" => $entry["positions"]["latitude"] ?? null,
    //         "_longitude" => $entry["positions"]["longitude"] ?? null,
    //         "_altitude" => $entry["positions"]["altitude"] ?? null,
    //         "_speed" => $entry["positions"]["speed"] ?? null,
    //         "_course" => $entry["positions"]["course"] ?? null,
    //         "_thisAddress" => $entry["positions"]["address"] ?? null,
    //         "_accuracy" => $entry["positions"]["accuracy"] ?? null,
    //         "_network" => $entry["network"] ?? null
    //     ]);
    // }
    // }


    // foreach ($vehicles as $vehicle) {
    //     $vehicleSQL->execute([
    //         "_id" => $vehicle["id"],
    //         "_title" => $vehicle["title"],
    //         "_stat" => $vehicle["status"],
    //         "_content" => $vehicle["content"],
    //         "_created" => $vehicle["created"],
    //         "_last_modified" => $vehicle["last_modified"],
    //         "_edit_lock" => $vehicle["custom_fields"]["_edit_lock"][0] ?? null,
    //         "_edit_last" => $vehicle["custom_fields"]["_edit_last"][0] ?? null,
    //         "_tracker" => $vehicle["custom_fields"]["tracker"][0] ?? null,
    //         "_vehicletype" => $vehicle["custom_fields"]["vehicletype"][0] ?? null,
    //         "_adjust" => $vehicle["custom_fields"]["adjust"][0] ?? null,
    //         "_fleet" => $vehicle["custom_fields"]["fleet"][0] ?? null,
    //         "_last_maintenance" => $vehicle["custom_fields"]["lastmaintenance"][0] ?? null,
    //         "_last_report" => $vehicle["custom_fields"]["last_report"][0] ?? null,
    //         "_deploy" => $vehicle["custom_fields"]["deploy"][0] ?? null,
    //         "_b2blocation" => $vehicle["custom_fields"]["b2blocation"][0] ?? null,
    //         "_b2blocation_coordinates" => $vehicle["custom_fields"]["b2b_location_coordinates"][0] ?? null,
    //         "_sleutelcode" => $vehicle["custom_fields"]["sleutelcode"][0] ?? null,
    //         "_station_based" => $vehicle["custom_fields"]["station_based"][0] ?? null,
    //         "_project" => $vehicle["custom_fields"]["project"][0] ?? null,
    //         "_special_project_desc" => $vehicle["custom_fields"]["special_project_description"][0] ?? null,
    //         "_lastpump" => $vehicle["custom_fields"]["lastpump"][0] ?? null,
    //         "_station_coords" => $vehicle["custom_fields"]["station_coords"][0] ?? null,
    //         "_yeply" => $vehicle["custom_fields"]["yeply"][0] ?? null
    //     ]);
    // }

?>

