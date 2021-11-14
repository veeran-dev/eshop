    <script type="text/javascript">
      var baseDir = '{$content_dir}';
      var static_token = '{$static_token}';
      var token = '{$token}';
      var id_employee = '{$cookie->id_employee}';
      var admin_token = '{$cookie->token_admin}';
      var employee_role = '{$cookie->employee_role}';
      var token_admin_global = '{$cookie->token_admin_global}';
      var admin_role = 0;
      if(employee_role ==3){
        admin_role = 1;
      }
    </script>

    <script type="text/javascript" src="catalog/js/jquery.min.js"></script>
    <script type="text/javascript" src="catalog/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="catalog/js/jquery-ui.js"></script>
    <script type="text/javascript" src = "catalog/js/angular.min.js"></script>
    <script type="text/javascript" src="catalog/js/ui-bootstrap-tpls-0.10.0.min.js"></script>
    <script type="text/javascript" src = "catalog/js/angular-route.min.js"></script>
     <script src="catalog/js/sortable.js" type="text/javascript"></script>
    
    <script type="text/javascript" src="dash/bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="dash/js/jquery.dcjqaccordion.2.7.js"></script>
    <script type="text/javascript" src="{$content_dir}js/jquery/jquery.autocomplete.js"></script>
    <script src="dash/js/jquery.scrollTo.min.js"></script>
    <script src="dash/js/jquery.nicescroll.js"></script>
    <script src="dash/js/scripts.js"></script>

    <script type="text/javascript" src="dash/js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script type="text/javascript" src="catalog/js/angular-toast.min.js"></script>
    <script type="text/javascript" src="rm/js/multiselect/js/select2.min.js"></script>

    <script type="text/javascript" src="catalog/js/app.js"></script>

    {if $cookie->id_role == 2}
      <script type="text/javascript" src="catalog/js/approver.js"></script>
    {elseif $cookie->id_role == 3}
    <script type="text/javascript" src="catalog/js/quality-check.js"></script>
    {else}
    <script type="text/javascript" src="catalog/js/catalog.js"></script>
    {/if}
  </body>
</html>