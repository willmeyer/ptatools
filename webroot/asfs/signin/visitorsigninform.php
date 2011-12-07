<h2>Please Sign In</h2>
<form>
    <p>
        <label for="">Your Name:</label>
        <input type="text" autocapitalize="on" autocorrect="off" id="newentry-name" name="newentry-name" />
    </p>
    <p>
        <label for="">Reason for Visit:</label>
        <select id="newentry-purpose">
            <option value="classroom">Class Visit</option>
            <option value="teacher">Teacher Visit</option>
            <option value="business">School Business</option>
            <option value="other">Other</option>
        </select>
    </p>
    <p>
        <label for="">Notes (optional):</label>
        <input type="text" autocapitalize="on" autocorrect="on" id="newentry-notes" name="newentry-notes"></textarea>
<!--
        <textarea id="newentry-notes" name="newentry-notes" rows="1" cols="40"></textarea>
-->
    </p>
    <p>
        <input type="submit" id="newentry-submit" name="newentry-submit" value="Sign In Now">
    </p>
</form>
