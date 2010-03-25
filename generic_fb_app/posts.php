<?php 

require_once('rousseau-includes/rousseau-utilities.php');


start_db_connection();
	

$site_id = $_GET['rousseau_id'];
if (!$site_id) {
   $site_id = $_POST['rousseau_id'];
}

$events = grab_recent_events($site_id);

if ($events) {
   echo '{
      "api_key" : "' . get_fb_api_key($events[0]->site_id) . '",
      "api_secret" : "' . get_fb_api_secret($events[0]->site_id)  . '",
      "entries" : [
   ';


   $num_events = sizeof($events);

   //foreach ($events as $event) {
   for ($i = 0; $i < $num_events; $i++) {
   echo '
      {
         "id": "' . $events[$i]->id . '",
         "site_id": "' . $events[$i]->site_id . '",
         "content": "' . $events[$i]->content . '",
         "timestamp": "' . $events[$i]->timestamp . '",
         "xid": "' . $events[$i]->fb_id . '"
      }';
      if ($i != ($num_events -1)) {
         echo ",";
      }
   }

   echo '
      ]
   }';
}

clean_up();

?>

