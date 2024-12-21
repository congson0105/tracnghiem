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
    <div class="row">
      <!-- phần tìm kiếm -->
      <div class="col-sm-4">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Tìm kiếm" id="txtSearch" />
          <div class="input-group-btn">
            <button class="btn btn-primary" type="submit" id="btnSearch">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </div>
        </div>

      </div>
      <!-- kết thúc tìm kiếm -->

      <!-- Phần phân trang -->
      <div class="col-sm-6">
        <nav aria-label="Page navigation example">
          <ul class="pagination" style="margin:0px; padding-top:0; margin-left:10px;" id="pagination">



          </ul>
        </nav>

      </div>
      <!-- Kết thúc phân trang -->
      <div class="col-sm-2 text-right">
        <button id="btnQuestion" class=" btn btn-success">+</button>
      </div>
    </div>

    <table class="table table-striped">

      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Câu hỏi</th>
          <th scope="col"></th>

        </tr>
      </thead>

      <tbody id="questions">
        <?php include('view.php') ?>
      </tbody>

    </table>
  </div>
</body>

</html>
<?php include('mdlQuestion.php') ?>
<script type="text/javascript">
  var page = 1;
  // trong sự kiện trang load xong thì gọi tới hàm load ds câu hỏi
  $(document).ready(function () {
    $('#btnSearch').click();
  });

  $('#btnQuestion').click(function () {
    // khi tham mới mặc định id của câu hỏi là 1 chuối trống
    $('#txtQuestionId').val('');
    // set các giá trị mặc định của các input khi thêm m ới
    $('#txaQuestion').val('');
    $('#txaQuestionA').val('');
    $('#txaQuestionB').val('');
    $('#txaQuestionC').val('');
    $('#txaQuestionD').val('');

    // reset lị gia tri cho cac radio button -->khong chon thang nao het
    $('#rdOptionA').prop('checkd', false);
    $('#rdOptionB').prop('checkd', false);
    $('#rdOptionC').prop('checkd', false);
    $('#rdOptionD').prop('checkd', false);

    $('#modalQuestion').modal();
  })

  $('#btnSearch').click(function () {
    let search = $('#txtSearch').val().trim();
    ReadData(search);
    Pagination(search);
  });



  // sự kiện của button xem chi tiết câu hỏi
  $(document).on('click', "input[name='view']", function () {
    var trid = $(this).closest('tr').attr('id'); // table row ID 

    GetDetail(trid);
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
  // sự kiện cập nhập câu hỏi
  $(document).on('click', "input[name='update']", function () {
    var bid = this.id; // button ID 
    var trid = $(this).closest('tr').attr('id'); // lấy dữ liệu của dòng được chọn trên table khi click vào button có tên là update
    // console.log(trid);
    GetDetail(trid); // lấy dữ liệu câu hỏi dựa vào id tim được ở trên và đổ dữ liệu vào input

    $('#txaQuestion').attr('readonly', false);
    $('#txaQuestionA').attr('readonly', false);
    $('#txaQuestionB').attr('readonly', false);
    $('#txaQuestionC').attr('readonly', false);
    $('#txaQuestionD').attr('readonly', false);

    $('#rdOptionA').attr('disabled', false);
    $('#rdOptionB').attr('disabled', false);
    $('#rdOptionC').attr('disabled', false);
    $('#rdOptionD').attr('disabled', false);

    $('#txtQuestionId').val(trid);
    // hiện lại nút xác nhận
    $('#btnSubmit').show();
  });
  // sự kiện của button xóa câu hỏi
  $(document).on('click', "input[name='delete']", function () {
    var bid = this.id; // button ID
    var trid = $(this).closest('tr').attr('id'); // lấy dữ liệu của dòng được chọn trên table khi click vào button có tên là update

    if (confirm("Bạn chắc chắn muôn xóa câu hỏi này?") == true) {
      $.ajax({
        url: 'delete.php',
        type: 'post',
        data: {
          id: trid
        },
        success: function (data) {
          alert(data);
          ReadData();
        }
      });
    }
  });
  // hàm load thông ti câu hỏi dựa vào id
  function GetDetail(id) { // lấy câu hỏi dựa vào id câu hỏi
    $.ajax({
      url: 'detail.php', // chỉ đường dẫn tới file detai.php để lấy thông tin câu hỏi
      type: 'get',// phương thuc get
      data: {
        id: id// truyền tham số có giá trị bầng giá trị của id câu hỏi
      },
      success: function (data) {

        let q = JSON.parse(data);// ép kiểu dữ liệu trả về qua json
        console.log(q['question']);// set giá trị của textarea có id txaQuestion

        $('#txaQuestion').val(q['question']);
        $('#txaQuestionA').val(q['option_a']);// set giá trị của textarea có id là txaOption_a(đáp án A)
        $('#txaQuestionB').val(q['option_b']);
        $('#txaQuestionC').val(q['option_c']);
        $('#txaQuestionD').val(q['option_d']);

        $('#modalQuestion').modal();// hiện modalQuestion

        switch (q['answer']) { // dùng switch case dựa vào giá trị của answer để tích đáp án
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
  }
  // hàm load dựa vào cauhoi
  function ReadData(search) {
    $.ajax({
      url: 'view.php',
      type: 'get',
      data: {
        search: search,
        page: page
      },
      success: function (data) {
        $('#questions').empty();
        $('#questions').append(data);
      }
    });
  }

  $('#txtSearch').on('keypress', function (e) {
    if (e.which === 13) {

      $('#btnSearch').click();
    }
  });

  $("#pagination").on("click", "li a", function (event) {
    event.preventDefault();
    page = $(this).text();
    ReadData($(txtSearch).val());
  });



  function Pagination(search) {
    $.ajax({
      url: 'pagination.php',
      type: 'get',
      data: {
        search: search
      },
      success: function (data) {
        console.log(data);
        if (data <= 1) {
          $('#pagination').hide();
        } else {
          $('#pagination').show();
          $('#pagination').empty();
          let pagi = '';
          for (i = 1; i <= data; i++) {
            pagi += '<li class="page-item" ><a class="page-link" href="#">' + i + '</a></li>';
          }
          $('#pagination').append(pagi);
        }
      }
    });
  }
</script>