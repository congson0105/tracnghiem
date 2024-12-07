<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link rel="stylesheet" href="">
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
    integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
    crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Câu hỏi</th>
          <th scope="col"></th>

        </tr>
      </thead>
      <tbody>
        <div class="row">
          <div class="col-sm-12 text-right">
            <button id="btnQuestion" class=" btn btn-success">+</button>
          </div>
        </div>
        <?php include('connect.php') ?>
        <?php
        $sql = $conn->prepare("SELECT * FROM cauhoi");
        $sql->execute();
        $index = 1;
        while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
          echo '<tr id=' . $result['id'] . '>';
          echo '<th scope="row">' . ($index++) . '</th>';
          echo '<td class="text-primary">' . $result['question'] . '</td>';
          echo '<td>';
          echo '<input type="button" class="btn btn-xs btn-info" value="Xem" name="view"> &nbsp;';
          echo '<input type="button" class="btn btn-xs btn-warning" value="Sửa" name="update"> &nbsp;';
          echo '<input type="button" class="btn btn-xs btn-danger" value="Xóa" name ="delete"> ';
          echo '</td>';
          echo '</tr>';
        }
        ?>

      </tbody>
    </table>
  </div>
</body>

</html>
<?php include('mdlQuestion.php') ?>
<script type="text/javascript">
  $('#btnQuestion').click(function () {
    $('#modalQuestion').modal();
  })

  // $('input[type=button]').click(function () {
  //   var bid = this.id; // button ID 
  //   var trid = $(this).closest('tr').attr('id'); // table row ID 
  //   console.log(trid);
  // });  

  $("input[name='view']").click(function () {
    var bid = this.id; // button ID 
    var trid = $(this).closest('tr').attr('id'); // table row ID 
    // console.log(trid);
    $.ajax({
      url: 'detail.php',
      type: 'get',
      data: {
        id: trid
      },
      success: function (data) {

        let q = JSON.parse(data);
        console.log(q['question']);
        $('#modalQuestion').modal();
        $('#txaQuestion').val(q['question']);
        $('#txaQuestionA').val(q['option_a']);
        $('#txaQuestionB').val(q['option_b']);
        $('#txaQuestionC').val(q['option_c']);
        $('#txaQuestionD').val(q['option_d']);

        switch (q['answer']) {
          case 'A':
            $('#rdOptionA').prop('checked', true);
            break;
          case 'B':
            $('#rdOptionB').prop('checked', true);
            break;
          case 'C':
            $('#rdOptionC').prop('checked', true);
            break;
          case 'D':
            $('#rdOptionD').prop('checked', true);
            break;
        }

      }

    });
    // khong cho sua noi dung cau hoi, dap an
    $('#txaQuestion').attr('readonly', 'readonly');
    $('#txaQuestionA').attr('readonly', 'readonly');
    $('#txaQuestionB').attr('readonly', 'readonly');
    $('#txaQuestionC').attr('readonly', 'readonly');
    $('#txaQuestionD').attr('readonly', 'readonly');
    // không cho sua dap an
    $('#rdOptionA').attr('disabled', 'readonly');
    $('#rdOptionB').attr('disabled', 'readonly');
    $('#rdOptionC').attr('disabled', 'readonly');
    $('#rdOptionD').attr('disabled', 'readonly');
    // an nút xác nhận
    $('#btnSubmit').hide();
  });


</script>