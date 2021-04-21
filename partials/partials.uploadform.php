<form action="./index.php" method='post' enctype="multipart/form-data">
    <fieldset>
        <legend>CSVDB Upload form</legend>

        <div class="form__row">
            <label for="field--name">Name:</label>
            <input type="text" name="field--name" id="field--name"/>
        </div>
        <div class="form__row">
            <label for="field--delimiter">Delimiter:</label>
            <select name="field--delimiter" id="field--delimiter">
                <option value="0">Automatic detection (default)</option>
                <option value="1">Tab</option>
                <option value="2">Semicolon (;)</option>
                <option value="3">Pipe (|)</option>
                <option value="4">Comma (,)</option>
            </select>
        </div>
        <div class="form__row">
            <label for="field--file">Import file:</label>
            <input type="file" name="field--file" id="field--file"/>
        </div>
        <div class="form__row">
            <button type="submit" name="upload--button">Upload</button>
        </div>
    </fieldset>
</form>