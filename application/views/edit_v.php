<body>
<?php
    $title = '';
    $mode='insert';
    if(isset($list))
    {
        print_r($list);
        $title = $list['title'];
        $subtitle = $list['subtitle'];
        $img_list = $list['img_list'];
        $mode='update';
    }
?>
<h1>포트폴리오 <?php if ($mode=='insert'){echo '등록';}else{echo '수정';}?></h1>
<form enctype="multipart/form-data" method="post" action="/portfolio/<?php echo $mode;?>_run">
    <?php if(isset($list['idx'])):?>
    <input type="hidden" name="p_idx" value="<?php echo $list['idx'];?>">
    <?php endif;?>
    <dl>
        <dt>분류</dt>
<!--        <dd>-->
<!--            <input type="radio" name="category" value="web" checked>WEB & MOBILE-->
<!--            <input type="radio" name="category" value="app">APP-->
<!--            <input type="radio" name="category" value="ci">CI&BI-->
<!--        </dd>-->
        <dt>제목</dt>
        <dd>
            <input type="text" name="title" value="<?php echo $title;?>"></dd>
<!--        <dt>부제</dt>-->
<!--        <dd><input type="text" name="subtitle" value="--><?php //echo($subtitle)?><!--"></dd>-->
<!--        <dt>URL</dt>-->
<!--        <dd><input type="text" name="url" value="--><?php //echo($list->url)?><!--"></dd>-->
<!--        <dt>제작 목적</dt>-->
<!--        <dd><textarea name="purpose">--><?php //echo($list->purpose)?><!--</textarea></dd>-->
<!--        <dt>제작 기간</dt>-->
<!--        <dd><input type="text" name="period" value="--><?php //echo($list->period)?><!--"></dd>-->
<!--        <dt>작업 인원</dt>-->
<!--        <dd><input type="text" name="member" value="--><?php //echo($list->member)?><!--"></dd>-->
<!--        <dt>사용 언어</dt>-->
<!--        <dd>-->
<!--            <input type="checkbox" name="language[]" value="HTML">HTML-->
<!--            <input type="checkbox" name="language[]" value="CSS">CSS-->
<!--            <input type="checkbox" name="language[]" value="php">PHP-->
<!--            <input type="checkbox" name="language[]" value="java">Java-->
<!--            <input type="checkbox" name="language[]" value="js">JavaScript-->
<!--            <input type="checkbox" name="language[]" value="python">Python-->
<!--        </dd>-->
<!--        <dt>프레임워크</dt>-->
<!--        <dd>-->
<!--            <input type="checkbox" name="framework[]" value="ci">CodeIgniter-->
<!--        </dd>-->
<!--        <dt>라이브러리</dt>-->
<!--        <dd>-->
<!--            <input type="checkbox" name="library[]" value="ci">-->
<!--        </dd>-->
<!--        <dt>참여도-개발</dt>-->
<!--        <dd><input type="number" name="part_dev"></dd>-->
<!--        <dt>참여도-기획</dt>-->
<!--        <dd><input type="text" name="part_plan"></dd>-->
<!--        <dt>참여도-디자인</dt>-->
<!--        <dd><input type="text" name="part_design"></dd>-->
<!--        <dt>개발 환경</dt>-->
<!--        <dd><input type="text" name="environment"></dd>-->
<!--        <dt>클라이언트</dt>-->
<!--        <dd><input type="text" name="client"></dd>-->
<!--        <dt>회사</dt>-->
<!--        <dd><input type="text" name="company"></dd>-->
        <dt>이미지파일</dt>
        <dd>
            <ul id="img_list">
                <?php if(isset($img_list)):?>
                <?php foreach ($img_list as $img):?>
                <li class="img_row">
                    <img src="/<?php echo $img->img?>" style="width:80px;">
                    <input class="getfile" type="file" name="img[]" accept="image/*">
                    <input type="hidden" name="img_idx[]" value="<?php echo $img->img_idx;?>">
                    <button type="button" class="to_up">▲</button>
                    <button type="button" class="to_down">▼</button>
                    <button class="delete_img">삭제</button>
                </li>
                <?php endforeach;?>
                <?php endif;?>
                <li class="img_row">
                    <input class="getfile" type="file" name="img[]" accept="image/*">
                    <input type="hidden" name="img_idx[]" value="">
                    <button type="button" class="to_up">▲</button>
                    <button type="button" class="to_down">▼</button>
                    <button class="delete_img">삭제</button>
                </li>
                <li class="img_row">
                    <input class="getfile" type="file" name="img[]" accept="image/*">
                    <input type="hidden" name="img_idx[]" value="">
                    <button type="button" class="to_up">▲</button>
                    <button type="button" class="to_down">▼</button>
                    <button class="delete_img">삭제</button>
                </li>
            </ul>
        </dd>
    </dl>
    <button type="button" id="add_img">이미지 추가</button>
    <hr>
    <button type="button" id="m_">제출</button>
</form>
</body>
<script src="/js/jquery-3.1.1.min.js"></script>
<script>
    $('#add_img').on('click',function () {
        var ul = $('#img_list');
        ul.append('<li class="img_row"><input type="file" class="getfile" name="img[]" accept="image/*"><input type="hidden" name="img_idx[]" value=""></li>');
    });

    $('.delete_img').on('click',function () {
        var li = $(this).closest('li');
        li.remove();
    });

    $(function () {
        console.log("%c Portfolio of Bae Myoung Jin ", "color: crimson; font-size:40px; font-weight:bold; font-family:Arial");

        $('.to_up').on('click',function () {
            var li = $(this).closest('li');
            var prev_li = li.prev('li');
            prev_li.before(li);
        });

        $('.to_down').on('click',function () {
            var li = $(this).closest('li');
            var next_li = li.next('li');
            next_li.after(li);
        });

        $('#m_').on('click',function () {
            $('.getfile').each(function() {

                if($(this).val() == '' && $(this).next().val() ==''){
                    $(this).closest('li').remove();
                }
            });
            $('form').submit();
        });

//        var file = document.querySelector('.getfile');
//
//        file.onchange = function () {
//            var fileList = file.files ;
//
//            // 읽기
//            var reader = new FileReader();
//            reader.readAsDataURL(fileList [0]);
//
//            //로드 한 후
//            reader.onload = function  () {
//                document.querySelector('#preview').src = reader.result ;
//            };
//        };
    });


</script>