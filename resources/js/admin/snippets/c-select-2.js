$(document).ready(function (){
    let cSelect2 = $(".c-select-2");
    let cSmall, sInput;
    let searchedVal = '';
    let searching = 0;

    let uri = '/system/search/clubs/by-name-v2';
    let imgUri = "/images/club-images/";

    if(cSelect2.length){
        /**
         *  First, create new input label for real data information
         */
        $(".input__search_wrapper").append(function (){
            return $("<input>").attr('type', 'hidden')
                .attr('id', cSelect2.attr('s-input'))
                .attr('name', cSelect2.attr('s-input'))
                .attr('value', cSelect2.attr('s-val'));
        });

        /**
         *  Setup the info bar
         */
        cSmall = $("#"  + cSelect2.attr("aria-describedby"));
    }

    let searchIt = function (value){
        $.ajax({
            url: $(".c-select-2").attr('route'),
            method: 'POST',
            dataType: "json",
            data: {
                term: value
            },
            success: function success(response) {
                if(response['code'] === '0000'){
                    let data = response['data']['data'];

                    /* First, remove all other */
                    $(".input__search_wrapper").find(".c-select-2-wrapper").remove();

                    if(data.length){

                        let wrapper = $("<div>").attr('class', 'c-select-2-wrapper');

                        for(let i=0; i<data.length; i++){
                            wrapper.append(function (){
                                return $("<div>").attr('class', 'cs2-row').attr('value', data[i]['id'])
                                    .attr('text', data[i]['title'])
                                    // .append(function (){
                                    //     return $("<div>").attr('class', 'cs2-img-w')
                                    //         .append(function (){
                                    //             return $("<img>").attr('src', imgUri + data[i]['image']);
                                    //         });
                                    // })
                                    .append(function (){
                                        return $("<span>").text(data[i]['title'] + ', ' + data[i]['city'] /* + ', ' + data[i]['country_rel']['name_ba'] */);
                                    });
                            });
                        }

                        $(".input__search_wrapper").append(function (){
                            return wrapper;
                        });
                    }
                }
            }
        });
    };

    /**
     *  On keyup on main input field
     */
    $("body").on('keyup', '.c-select-2', function(e) {
        searchedVal = $(this).val();

        if(searchedVal.length >= 2){
            cSmall.text("Pretraživanje ..");

            /* Rise flag for searching */
            searching = true;

            searchIt(searchedVal);
        }else{
            cSmall.text("Molimo da unesete " + (2 - searchedVal.length) + " ili više karaktera .. ");

            /* Remove searched elements */
            $(".input__search_wrapper").find(".c-select-2-wrapper").remove();
        }
    }).on('focus', '.c-select-2', function(e) {
        if($(this).val().length > 2){
            cSmall.text("Pretražite ..");

            searchIt($(this).val());
        }else{
            $("#"  + cSelect2.attr("aria-describedby")).text("Molimo da unesete 2 ili više karaktera .. ");
        }
    }).on('focusout', '.c-select-2', function(e) {
        cSmall.text(cSmall.attr('default'));
    }).on('click', '.cs2-row', function(e) {
        $("#" + cSelect2.attr('s-input')).val($(this).attr('value'));

        cSelect2.val($(this).attr("text"));

        /* Remove searched elements */
        $(".input__search_wrapper").find(".c-select-2-wrapper").remove();
    }).on('click', 'body', function(e){
        if(!$(e.target).hasClass('c-select-2-wrapper') ) {
            $(".input__search_wrapper").find(".c-select-2-wrapper").remove();
        }else{
            console.log("anywhere ..");
        }
    });

    $('html').click(function(e) {
        if(!$(e.target).hasClass('c-select-2-wrapper') && !$(e.target).hasClass('c-select-2')) {
            $(".input__search_wrapper").find(".c-select-2-wrapper").remove();
        }

        if(!$(e.target).hasClass('mac_w_clk')) {
            $(".more__actions_w").addClass('d-none');
        }
    });
});
