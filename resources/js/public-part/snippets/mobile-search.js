$( document ).ready(function() {
    let searchedVal = '', searching = false;
    let previewUri = '/forecast/preview/';
    let searchUri = '/forecast/search/';

    /** Show or hide search menu in full screen */
    let showHideMenu = function (visible){
        if(visible) {
            $(".mobile__search_wrapper").addClass('visible');

            /* Show previous search */
            $(".previous__search_w").removeClass('d-none');
        }
        else $(".mobile__search_wrapper").removeClass('visible');
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
        let searchBody = $(".msw__search__body");

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
                                return $("<div>").attr('class', 'sv__row go-to').attr('uri', previewUri + data[i]['id'])
                                    .append(function (){
                                        return $("<h6>").text(data[i]['title']);
                                    })
                                    .append(function (){
                                        return $("<p>").text(data[i]['description']);
                                    })
                            });

                            if(i > 10) break;
                        }

                        searchBody.append(function (){
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

    let searchIt = function (uri, value){
        if(value.length >= 1){
            /* Hide previous search */
            $(".previous__search_w").addClass('d-none');

            searchCitiesByText(uri ,value);

            /* Show search offer */
            $(".search__row").removeClass('d-none');
            if(value !== '' && value !== ' '){
                $("#searched__value").text(value).attr('uri', searchUri + value);
            }
        }else{
            /* Remove searched elements */
            cleanSearchHistory();

            /* Show previous search */
            $(".previous__search_w").removeClass('d-none');

            /* Hide search offer */
            $(".search__row").addClass('d-none');
            $("#searched__value").text("");
        }
    }

    $("body").on('keyup', '#mobile-menu-search', function(e) {
        searchIt($(this).attr('uri'), $(this).val());
    }).on('click', '.go-to', function(e) {
        /**
         * Go-To URI
         * @type {*|jQuery}
         */
        window.location = $(this).attr('uri');
    }).on('click', '#searched__value', function (e){
        window.location = $(this).attr('uri');
    })

    /**
     *  Show mobile search on search icon click
     */
    $(".mobile__search__trigger").click(function (){
        showHideMenu(true);
        $(".mobile-menu-search").focus();
    });
    $(".msw_sa_cancel_w").click(function (){
        showHideMenu(false);
        /* Remove searched elements */
        cleanSearchHistory();
        /* Remove search input */
        $("#mobile-menu-search").val("");
    });

});
