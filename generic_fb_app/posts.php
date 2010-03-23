<?php 

require_once ('utilities.php');


start_db_connection();
	

$site_id = $_GET['rousseau_id'];
if (!$site_id) {
   $site_id = $_POST['rousseau_id'];
}

$events = grab_recent_events($site_id);


echo '{
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
      "xid": "' . $events[$i]->get_fb_xid() . '"
   }';
   if ($i != ($num_events -1)) {
      echo ",";
   }
}

echo '
   ]
}';

clean_up();

?>

