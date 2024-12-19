$( document ).ready(function() {
    let searchedVal = '', searching = false;
    let previewUri = '/forecast/preview/';

    let setSearch = function (show){
        /**
         *  When user is on mobile phone, skip homepage search, and offer global search
         */
        if(window.innerWidth <= 800) {
            $(".mobile__search_wrapper").addClass('visible');
            return;
        }

        if(show){
            $(".dropdown__wrapper").removeClass('d-none');
            $(".search__wrapper").addClass('focused');
        }else{
            $(".search__wrapper").removeClass('focused');
            $(".dropdown__wrapper").addClass('d-none');
        }
    }

    let cleanSearchHistory = function (){
        $(".searched__values").remove();
    }

    let searchCitiesByText = function (uri, value){
        if(searching) return;
        /* Rise flag for searching */
        searching = true;

        cleanSearchHistory();
        /* Search body wrapper */
        let searchBody = $(".dropdown__wrapper");

        $.ajax({
            url: uri,
            method: 'POST',
            dataType: "json",
            data: {
                term: value
            },
            success: function success(response) {
                if(response['code'] === '0000'){
                    let data = response['data']['data'];

                    if(data.length){
                        let wrapper = $("<div>").attr('class', 'searched__values skip-closing');

                        for(let i=0; i<data.length; i++){
                            wrapper.append(function (){
                                return $("<div>").attr('class', 'search_row skip-home go-to').attr('uri', previewUri + data[i]['id'])
                                    .append(function (){
                                        return $("<h3>").text(data[i]['title']);
                                    })
                            });

                            if(i >= 4) break;
                        }

                        searchBody.prepend(function (){
                            return wrapper;
                        });
                    }
                }else{
                    cleanSearchHistory();
                }

                searching = false;
            }
        });
    };

    /**
     *  On keyup on main input field
     */
    $("body").on('keyup', '#main-search', function(e) {
        searchedVal = $(this).val();

        if(searchedVal.length >= 2){
            setSearch(true);

            searchCitiesByText($(this).attr('uri'), $(this).val());
        }else{
            /* Remove searched elements */
            setSearch(false);
        }
    }).on('focus', '#main-search', function(e) {
        setSearch(true);
    }).on('focusout', '#main-search', function(e) {
        // setSearch(false);
    }).on('click', '.cs2-row', function(e) {

    }).on('click', 'body', function(e){
        if(!$(e.target).hasClass('c-select-2-wrapper') ) {
            // $(".input__search_wrapper").find(".c-select-2-wrapper").remove();
        }else{
            // console.log("anywhere ..");
        }
    });

});
