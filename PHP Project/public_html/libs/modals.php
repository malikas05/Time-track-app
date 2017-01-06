<!-- Login Modal -->
<div id="signIn" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="signInlLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="signInlLabel">Log In</h4>
            </div>
            <div class="modal-body">
                <form class="col-sm-8" id="loginForm" action="login.php" method="post" target="_self" data-toggle="validator">
                    <div class="form-group">
                        <label for="loginEmail">Email address</label>
                        <input type="email" class="form-control" id="loginEmail" placeholder="Email" name="email" pattern="^\S+@\S+$" placeholder="Email" data-error="Bruh, that email address is invalid" required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <input type="password" class="form-control" id="loginPassword" placeholder="Password" name="password" data-minlength="5" required>
                        <div class="help-block">Minimum of 5 characters</div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label><input type="checkbox" name="rememberMe"> Remember me</label>
                        </div>
                    </div>
                    <p>Not a user? Feel free to register <a href="register.php">here</a></p>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submitLog">Log In</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- Message Modal -->
<div id="messageModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="messageModalLabel">System Message</h4>
            </div>
            <div class="modal-body" id="messageModalBody">
                <p>No Message</p>
            </div>
            <div class="modal-footer" id="messageModalFooter">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Store time entries, projects, categoeries and tags in local storage if that fails display message
    var isDataStored = setStorageData(user_data);
    if( !~isDataStored.indexOf("Success") ){
        var messageText = "<p>" + isDataStored + "<br/>" + "If you are not logged in - we might not be able to save any changes you make.</p>";
        jQuery('#messageModalBody').html(messageText);
        jQuery('#messageModalLabel').text("Data Storage Issue");
        jQuery('#messageModal').modal('show');
    }
</script>
