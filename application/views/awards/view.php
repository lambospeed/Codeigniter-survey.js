<!-- About start here -->
<section class="about about-six padding-120">
    <div class="container">
        <div class="section-header text-center">
            <h2>View Nominees!</h2>
        </div>
        <?php foreach ($voteResult as $category => $value): ?>
                <div class="row" style="margin:15px">
                    <p><h4><?= $categories[$category];?></h4></p>
                    <?php foreach ($value as $key => $vote):?>
                        <div class="col-md-3">
                            <span><?= $nominees[$key]; ?></span>
                            <span class="badge"><?= $vote['voteCount'];?></span>
                        </div>
                    <?php endforeach;?>
                </div>

        <?php endforeach; ?>
    </div><!-- container -->
</section>
<!-- About end here -->