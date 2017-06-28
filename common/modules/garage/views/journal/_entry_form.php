<div class="row new-entry-row">
    <div class="col s12">
        <h5>Car's journal</h5>
    </div>
    <div class="col s12 m8 l9">
        <div class="btn-large waves-effect new-entry">add new entry</div>
    </div>
    <div class="col s12 m4 l3 input-field">
        <select name="sort">
            <option value="" disabled selected>Sort by name</option>
            <option value="">Sort by tags</option>
            <option value="">Sort by date</option>
        </select>
    </div>
</div>
<div class="row new-entry-wrap">
    <div class="col s12">
        <div class="entry bordered-box">
            <div class="row">
                <div class="input-field col s12">
                    <input type="text" id="etitle" class="validate">
                    <label data-error="wrong" data-success="right" for="etitle">Entry title</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="etext" class="materialize-textarea validate"></textarea>
                    <label for="etext" data-error="wrong" data-success="right">Entry text</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m6">
                    <select name="language" multiple>
                        <option value="" disabled selected>Entry language</option>
                        <option value="Russian">Russian</option>
                        <option value="English">English</option>
                        <option value="Arabic">Arabic</option>
                    </select>
                </div>
                <div class="input-field col s12 m6">
                    <select name="language">
                        <option value="" disabled selected>Entry type</option>
                        <option value="Expenses">Expenses</option>
                        <option value="Mileage">Mileage</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m4 l6">
                    <input type="text" id="mileage">
                    <label for="mileage">Mileage</label>
                </div>
                <div class="input-field col s12 m4 l3">
                    <input type="text" id="expenses">
                    <label for="expenses">Expenses</label>
                </div>
                <div class="input-field col s12 m4 l3">
                    <select name="currency">
                        <option value="USD" selected>USD</option>
                        <option value="AED">AED</option>
                    </select>
                </div>
            </div>
            <div class="row marg">
                <div class="input-field col s12">
                    <input type="checkbox" class="filled-in" id="hidentry">
                    <label for="hidentry">Hidden entry</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <button id="journal-submit-btn" class="waves-effect btn-large full" type="submit" name="send">submit</button>
                </div>
                <div class="col s12 m6">
                    <div class="btn-gray btn-ui waves-effect"><input type="file" multiple=""><span class="ico-photo-camera-outlined-interface-symbol"></span></div>
                    <a class="btn-gray btn-ui waves-effect popup-form" href="#addvideo"><span class="ico-video-camera"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>