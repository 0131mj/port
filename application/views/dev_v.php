<h1>웹 개발</h1>
<p>PHP / JSP / HTML / CSS</p>
<article>
    <?php foreach($portfolio_list as $port):?>
    <div class="column_1of1" style="clear:both">
        <h2 style="text-align: center; font-weight: bold"><?php echo $port->title;?>&nbsp;
            <br>&nbsp;
            <button><a href="<?php echo ROOT_DIR;?>portfolio/modify/<?php echo $port->idx?>">수정</a></button>
            <button><a href="<?php echo ROOT_DIR;?>portfolio/hide/<?php echo $port->idx?>">비공개로 전환</a></button>
            <button class="delete_port btn btn-danger" data-idx="<?php echo $port->idx?>">삭제</button>
        </h2>
        <?php foreach($port->img_list as $img):?>
            <img src="<?php echo ROOT_DIR.$img->img;?>" class="port_img">
        <?php endforeach;?>
        <p style="text-align: center">
            <a href="<?php echo $port->url;?>" target="_blank"><?php echo $port->url;?></a>
        </p>
        <dl class="portfolio_detail">
            <dt>제작 목적</dt><dd><?php echo $port->purpose;?></dd>
            <dt>제작 기간</dt><dd><?php echo $port->period;?></dd>
            <dt>작업 인원</dt><dd><?php echo $port->member;?>명</dd>
            <dt>사용 언어</dt><dd><?php echo $port->language;?></dd>
            <dt>개발 환경</dt><dd><?php echo $port->environment;?></dd>
            <dt>클라이언트</dt><dd></dd>
            <dt>컨셉</dt><dd></dd>
        </dl>
    </div>
    <?php endforeach;?>
</article>
<script src="/js/jquery-3.1.1.min.js"></script>
<script>
    $('.delete_port').on('click',function(){
        if(confirm('해당 글을 삭제하시겠습니까?') == true)
        {
            var idx = $(this).attr('data-idx');
            console.log(idx);
            window.location.href="/portfolio/delete/"+idx;
        }else
        {
            return false;
        }
    });

</script>