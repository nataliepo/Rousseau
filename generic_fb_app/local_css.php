<?php

function include_local_css () {
   echo "<style>
.wallkit_post {
/*
   border-bottom:1px solid #D8DFEA;
   margin:10px 10px 5px 0;
   padding-bottom:5px;
*/
}

.gray_box {
/*
   border: 1px solid #FF99CC !important;
*/
   background-color: #FFFFFF !important;
   margin-top: -3px !important;
   margin-bottom: -3px !important;   
/*   
   height: 25px !important;

*/
   /* 
      background-color:#F7F7F7;
      border:1px solid #CCCCCC;
   */
}

.wallkit_post h4{
    font-size:13px;
}

.wallkit_post .wallkit_profilepic img {

   /* 
   display:block;
   float:left;
   margin:0 10px 10px 0;
   width:50px;
   height:50px;
   */
}

.wallkit_post .wallkit_postcontent div {
   padding:0 0 0 0 !important;
}

.wallkit_post div.wallkit_actionset {
/*
   font-size:11px;
   padding-bottom:3px;
   color:#777;
*/
}

.wallkit_post div.wallkit_actionset .date{
   color:#777;
}



/* Hiding the string below the last comment for now. 
 * May also be hiding pagination, but ignoring for now...
 */
.wallkit_subtitle {
   display: none;
}


.braided_thumbnail_outer {
   float: left;
   padding: 2px 2px;
   width: 150px;
}
.braided_thumbnail {
   max-height: 146px;
   max-width: 146px;
   border: 0pt;
}

.braided_entry {
/*
   overflow: auto;
   width: 450px;
*/
/*
   border:1px dotted #ccc;
*/
   padding: 2px 2px;
}
.braided_entry_outer { 
/*
   border: 2px solid #aaa;
*/
   width: 600px;
}
.commentable_item {
/*
   margin-left: 50px; 
   padding-left: 10px;
   border: 2px solid #660033;

*/
   width: 600px;
   height: 50px;
}

img.connected {
   display: none !important;
}

</style>";
}


?>
