<div class="bordered-box add-post">
    <div class="bordered-box-top">
        <h6>Add new entry</h6>
    </div>
    <div class="bordered-box-content">
        <div id="post-form">
            <form id="entry-post-form">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="blog-title" name="Post[title]" type="text" required="required">
                        <label for="blog-title" id="entry-title-label">Title</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="entry-text" name="Post[message]" class="materialize-textarea" required="required"></textarea>
                        <label for="entry-text" id="entry-text-label">Message</label>
                    </div>
                    <div id="preview-area" class="col s12">
                        <input type="hidden" id="video-count" value="0">
                    </div>
                    <div class="col s12">
                        <a id="send" href="#" class="waves-effect btn-large">submit</a>
                        <div class="btn-gray btn-ui waves-effect">
                            <input id="image-file" name="Post[images][]" type="file" multiple="multiple" accept="gif|jpg|jpeg|png">
                            <span class="ico-photo-camera-outlined-interface-symbol"></span>
                        </div>
                        <div class="btn-gray btn-ui waves-effect ">
                            <a href="#newblogvideo" class="popup-form"><span class="ico-video-camera"></span></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>