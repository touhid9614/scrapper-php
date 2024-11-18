<?php include 'includes/tag-config.php' ?>
<?php include 'bolts/header.php' ?>
<?php //global $tag_configs; ?>

<div class="inner-wrapper">

    <?php $select = 'Tag Configuration'; include 'bolts/sidebar.php' ?>

    <script> var site_tag = true; </script>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>
		<div class="panel-body">
			<h3>We change this panel. Plz click the button to add those config.</h3>
			<a class="btn btn-info" href="tracking-config.php">Add Tag Config</a>
		</div>

    </section>
</div>

<?php include 'bolts/footer.php';
