<?php include(__DIR__.'/includes/header.php'); ?>
<?php include(__DIR__.'/includes/navbar.php'); ?>

<main>
  <div class="stats" id="stats-grid"></div>

  <div class="row-head">
    <div class="sec-title">Accounts <span id="acc-count"></span></div>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th><th>Account No.</th><th>Name</th>
          <th>Balance</th><th>Created</th><th>Actions</th>
        </tr>
      </thead>
      <tbody id="acc-tbody"></tbody>
    </table>
  </div>
</main>

<?php include(__DIR__.'/includes/modals.php'); ?>
<?php include(__DIR__.'/includes/footer.php'); ?>