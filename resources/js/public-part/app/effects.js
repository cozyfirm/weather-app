let makeItRain = function() {
    $(".rain").each(function (){
        console.log($(this).hasClass('light-rain'));

        //clear out everything
        $(this).empty();

        let density = 5;
        if($(this).hasClass('light-rain')) density = 20;

        let increment = 0;
        let drops = "";
        let backDrops = "";

        while (increment < 100) {
            //couple random numbers to use for various randomization's
            //random number between 98 and 1
            let randoHundo = (Math.floor(Math.random() * (50 - 1 + 1) + 1));
            //random number between 5 and 2
            let randoFiver = (Math.floor(Math.random() * (density - 2 + 1) + 2));
            //increment
            increment += randoFiver;
            //add in a new raindrop with various randomizations to certain CSS properties
            drops += '<div class="drop" style="left: ' + increment + '%; bottom: ' + (randoFiver + randoFiver - 1 + 100) + '%; animation-delay: 0.' + randoHundo + 's; animation-duration: 0.5' + randoHundo + 's;"><div class="stem" style="animation-delay: 0.' + randoHundo + 's; animation-duration: 0.5' + randoHundo + 's;"></div><div class="splat" style="animation-delay: 0.' + randoHundo + 's; animation-duration: 2' + randoHundo + 's;"></div></div>';
            backDrops += '<div class="drop" style="right: ' + increment + '%; bottom: ' + (randoFiver + randoFiver - 1 + 100) + '%; animation-delay: 0.' + randoHundo + 's; animation-duration: 0.5' + randoHundo + 's;"><div class="stem" style="animation-delay: 0.' + randoHundo + 's; animation-duration: 0.5' + randoHundo + 's;"></div><div class="splat" style="animation-delay: 0.' + randoHundo + 's; animation-duration: 2' + randoHundo + 's;"></div></div>';
        }

        $(this).append(drops);
    });
}
/** Call function for make it rain */
makeItRain();
