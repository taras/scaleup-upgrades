<?php get_header(); ?>

  <div id="wrapper">
    <div class="container">
      <div class="row span4">

        <h2>Upgrades</h2>

        <?php the_form( 'upgrades' ); ?>

      </div>
      <div class="row span4">

        <h2>Alerts</h2>
        <div id="alerts">
          
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    jQuery(document).ready( function($){
      $('#field_button').click(function(e){
        $( "input[type=checkbox]:checked" ).each(function(){
          var name = $(this).attr('name')
          $.ajax({
            url: 'upgrades/upgrade/'+name,
            dataType: 'json',
            type: 'POST'
          }).done(function ( data ) {
              $("input[name="+data.args.name+"]").prop('checked', true);
            });
        });
        e.preventDefault();
      });
    });
  </script>

<?php get_footer(); ?>