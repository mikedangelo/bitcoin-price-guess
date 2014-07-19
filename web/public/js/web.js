$(document).ready(function(){

   $('div#vote a').click(function(e)
   {
      var proj = $(this).attr('title');
      $('#vfproj').val(proj);
      $.ajax({
         url: 'vote.php',
         beforeSend: function() {  $('#vfproj').val(proj); console.log($('form#vf').serialize()); },
         type: 'POST',
         data: $('form#vf').serialize(),
      })
      .done(function(data) {
         // now that we have successfully voted, disable voting until
         // next pulse
         $('div#vote a').removeAttr('href');
         console.log(data);
      });
      return false;
   });
 
  function pulse()
  {
    // get ticker data defines these types
    var set = "btce_btcusd_ticker";
    var set = "coindesk_btcusd_ticker";
    var set = "bitstamp_btcusd_ticker";
    var localurl = "/pulse.php?type=ticker&set="+set;

    var a = $("#currentbid").html();
    $.getJSON(localurl,
      function(data) {
         console.log(data);
         price = data.price;
         $("#currentbid").html(data.price).hide().fadeIn(350);
         document.title = data.price + " - bitHorn";
         $("#ct").val(data.ct);
         $("#cb").val(data.cb);
         $('div#vote a').attr('href','vote.php');
         if (data.score == true)
         {
            var a = parseInt($("#highscore span").html());
            $("#highscore span").html(a+1);
            alert("You win!");
         }
         if (data.score == false)
         {
            alert("Sorry, try again.");
            $("#highscore span").html("0");
         }

    })
    .error(function(data) { $("#currentbid").html(a);
    });
  }
  pulse();
  setInterval(pulse, 10000);

});
