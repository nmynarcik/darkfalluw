<?php
  $con = mysql_connect("localhost","root","root");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysql_select_db("db", $con);

  $results = mysql_query("
         SELECT
            dfuw_posts.ID AS pid,
            dfuw_posts.post_title AS title,
            dfuw_postmeta.meta_key AS mkey,
            dfuw_postmeta.post_id AS pmid,
            dfuw_postmeta.meta_value AS mval
         FROM
            dfuw_posts
         INNER JOIN
            dfuw_postmeta ON dfuw_posts.ID = dfuw_postmeta.post_id
         WHERE
            dfuw_posts.post_type = 'poi'
         AND
            dfuw_posts.post_status = 'publish'
         AND
            dfuw_postmeta.meta_key IN ('_poi_loc' ,'_poi_level' ,'_poi_type')");

      $jsary = ["pois" => []];
      $lastPid = 0;
      $currentPid = 0;
      $title = "";
      $ifff = 0;
      $elss = 0;
        while($row = mysql_fetch_array($results))
        {
            $currentPid = $row['pid'];
            $title = $row['title'];

            $cmd = $row['mkey'];
            $cmt = $row['mval'];

            if($lastPid != $currentPid)
            {
                    $insAry = [];
                    $insAry = ["title"=> $title, $cmd => $cmt];
                    array_push($jsary["pois"], $insAry);
                    $lastPid = $currentPid;
                    $ifff = $ifff + 1;
                    $currentPid = 0;
            }
            else
            {
                    $ind = 0;
                    if($ifff > 0)
                    {
                            $ind = $ifff-1;
                    }
                    $insAry = [$cmd => $cmt];
                    $jsary["pois"][$ind][$cmd] = $cmt;
            }
          }

    echo json_encode($jsary);
?>
