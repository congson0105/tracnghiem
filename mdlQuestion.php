<div class="modal" tabindex="-1" role="dialog" id="modalQuestion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtQuestionId" value="">
                <div class="form-group">

                    <textarea class="form-control" id="txaQuestion" rows="1" placeholder="Câu hỏi"></textarea>
                </div>

                <div class="form-group">

                    <textarea class="form-control" id="txaQuestionA" rows="1" placeholder="Đán án A"></textarea>
                </div>

                <div class="form-group">

                    <textarea class="form-control" id="txaQuestionB" rows="1" placeholder="Đán án B"></textarea>
                </div>

                <div class="form-group">

                    <textarea class="form-control" id="txaQuestionC" rows="1" placeholder="Đán án C"></textarea>
                </div>

                <div class="form-group">

                    <textarea class="form-control" id="txaQuestionD" rows="1" placeholder="Đán án D"></textarea>
                </div>

                <hr class="clearfix">
                <div class="form-group">
                    <div class="row">
                        <div class="radio col-sm-3">
                            <label><input type="radio" id="rdOptionA">Đáp án A</label>
                        </div>

                        <div class="radio col-sm-3">
                            <label><input type="radio" id="rdOptionB">Đáp án B</label>
                        </div>

                        <div class="radio col-sm-3">
                            <label><input type="radio" id="rdOptionC">Đáp án C</label>
                        </div>

                        <div class="radio col-sm-3">
                            <label><input type="radio" id="rdOptionD">Đáp án D</label>
                        </div>

                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnSubmit">Xác nhận</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#btnSubmit').click(function () {
        let question = $('#txaQuestion').val();//lấy giá tri của textarea có id là txaQuestion gán cho biến quetion
        let option_a = $('#txaQuestionA').val();//lấy giá tri của textarea có id là txaQuestionA gán cho biến option_a
        let option_b = $('#txaQuestionB').val();//lấy giá tri của textarea có id là txaQuestionB gán cho biến option_b
        let option_c = $('#txaQuestionC').val();//lấy giá tri của textarea có id là txaQuestionC gán cho biến option_c
        let option_d = $('#txaQuestionD').val();//lấy giá tri của textarea có id là txaQuestionD gán cho biến option_d
        let answer = $('#rdOptionA').is(':checked') ? 'A' : $('#rdOptionB').is(':checked') ? 'B' : $('#rdOptionC').is(':checked') ? 'C' : $('#rdOptionD').is(':checked') ? 'D' : '';
        // xem thằng nào được check thì gán giá trị tương ứng, sử dụng thuật toán 3 ngôi
        // console.log(question, option_a, option_b, option_c, option_d, answer);

        // ràng buộc dữ liệu
        if (question.length == 0 || option_a.length == 0 || option_b.length == 0 || option_c.length == 0 ||
            option_d.length == 0) {
            alert('Vui long nhập đầy đủ câu hỏi và các đáp án');
            return 0;
        }
        if (answer.length == 0) {
            alert('Vui lòng chọn đáp án đúng');
            return 0;
        }
        let questionId = $('#txtQuestionId').val();
        if (questionId.length == 0) { // them moi cau hoi
            $.ajax({
                url: 'add_question.php',
                type: 'post',
                data: {
                    question: question,// bên trái là tên thuộc tính, bên phải là giá trị <--> tên biến bên trên
                    option_a: option_a,
                    option_b: option_b,
                    option_c: option_c,
                    option_d: option_d,
                    answer: answer
                },
                success: function (data) {

                    alert(data);
                    // reset lại giá trị của các texarea
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

                    $('#btnSearch').click();
                }
            });
        } else { // cập nhập cau hoi
            $.ajax({
                url: 'update.php',
                type: 'post',
                data: {
                    id: questionId,
                    question: question,// bên trái là tên thuộc tính, bên phải là giá trị <--> tên biến bên trên
                    option_a: option_a,
                    option_b: option_b,
                    option_c: option_c,
                    option_d: option_d,
                    answer: answer
                },
                success: function (data) {
                    alert(data);
                    $('$modalQuestion').modal('hide'); // ẩn modal sau khi update
                    $('#btnSearch').click();
                }
            });

        }
    });

</script>