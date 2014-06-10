<?php
session_start();
?>
<!DOCTYPE html>
<html>
   <head>
      <title>bithorn</title>
      <link rel="stylesheet" type="text/css" href="/bitcoin-price-guess/web/public/css/web.css" />
      <script src="http://code.jquery.com/jquery-latest.js"></script>
      <script src="/bitcoin-price-guess/web/public/js/web.js"></script>
   </head>
   <body>
      <h1>Mess with the bit, get the horns</h1>
      <div class="content">
         <div id="currentbid">
            <span></span>
         </div>
         <form id="vf" name="vote" method="post">
            <input type="hidden" id="ct" name="ct" value="" />
            <input type="hidden" id="cb" name="cb" value="" />
            <input type="hidden" id="cjst" name="cjst" value=""/>
            <input type="hidden" id="vfproj" name="prediction" />
            <div id="vote">
               <a href="vote.php" title="upvote"><span class="vote upvote">&nbsp;</span></a>
               <a href="vote.php" title="downvote"><span class="vote downvote">&nbsp;</span></a>
            </div>
         </form>
         <div style="clear:both;"></div>
      </div>
   </body>
</html>
