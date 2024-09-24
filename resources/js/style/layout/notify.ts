import $ from "jquery";

export class Notify {
    static params : any = {
        "message" : "This is default notifyMe message",
        "class" : "nt-success",
        "expiration" : 6000,
        'icon' : "fas fa-check",
        'hash' : 'none'
    };

    static customID : number = (new Date).getTime();
    static mainWrapper : any;
    static body : any;

    static getMainWrapper() : void {
        this.mainWrapper = $(".notifyMeWrapper");
    }
    static Me(options : any, expiration : number = 6000) : void{
        /* Check for main wrapper */
        this.getMainWrapper();
        /* Set static body */
        this.body = $("body");

        if (!this.mainWrapper.length) {
            this.body.append(function () {
                return $("<div/>").attr('class', 'notifyMeWrapper')
            });
        }

        if(options.length >= 1) this.params['message'] = options[0];

        console.log(options);

        if(options.length >= 2) {
            if(options[1] === 'success'){
                this.params['class'] = "nt-success";
                this.params['icon']  = "fas fa-check";
            }
            if(options[1] === 'warn'){
                this.params['class'] = "nt-warn";
                this.params['icon']  = "fas fa-exclamation-triangle";
            }
            if(options[1] === 'danger'){
                this.params['class'] = "nt-danger";
                this.params['icon']  = "fas fa-radiation";
            }
            if(options[1] === 'chat'){
                this.params['class'] = "nt-chat";
                this.params['icon']  = "fas fa-comment";
            }
        }
        /* Used for hash */
        if(options.length >= 3){
            this.params['hash'] = options[2];
        }
        this.params['expiration'] = expiration;

        let hash = this.params['hash'];

        /* Create new instance of self object */
        let $obj = this;
        /* Get wrapper */
        this.getMainWrapper();

        this.mainWrapper.append(function () {
            return $("<div/>").attr("id", $obj.customID)
                .attr('class', 'notifyMe')
                .attr('hash', hash)
                .append(function () {
                    return $("<div/>").attr('class', 'nt-inline')
                        .append(function () {
                            return $("<div/>").attr("class", "nt-icon")
                                .append(function () {
                                    return $("<i>").attr('class', $obj.params['icon']);
                                })
                        })
                        .append(function () {
                            return $("<p>").html($obj.params['message'])
                        })
                })
                .addClass($obj.params['class'])
                .hide()
                .fadeIn(500)
                .delay($obj.params['expiration'])
                .queue(function() {
                    $(this).remove();
                    if (!$( ".notifyMe" ).length) $obj.mainWrapper.remove();
                })
        });

        /* Ad listener for instant removal */
        this.body.on('click', "#" + $obj.customID, function () {
            if($(this).attr('hash') !== 'none'){
                window.location.href = '/dashboard/chat/conversation/' + $(this).attr('hash');
            }else{
                $(this).remove();
                if (!$( ".notifyMe" ).length) $obj.mainWrapper.remove();
            }
        });
    }
}
