/******************************************************
 * Upload file class
 ******************************************************/
class Upload {

    /**
     * Class constructor, called when instantiating new class object
     */
    constructor() {
        // declare our class properties
        // call init
        this.init();
    }

    /**
     * We run init when our class is first instantiated
     */
    init() {
        // bind events
        this.bindEvents();
    }

    /**
     * bind all necessary events
     */
    bindEvents() {
        let self = this;

        var myDropzone = new Dropzone("div#dropzone", {
            url: "/admin/files/upload",
            maxFilesize: 500
        });


    }

}


/******************************************************
 * Instantiate new class
 ******************************************************/
$(function() {
    window.Upload = new Upload();
});