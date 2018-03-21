<?php echo form_open('user/login'); ?>
<section class="about about-six padding-120">
    <div class="container">
        <div class="col-md-4 card p-3 bg-light col-md-offset-4">

            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Enter Username" required autofocus>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </div>
    </div>
</section>

<?php echo form_close(); ?> 