            <!-- content -->
            <div id="content">

                <!-- box -->
                <div id="box">
                    <h3>collects</h3>

                    <?php if( !empty( $collects ) ): ?>

                    <table width="100%">
                    <thead>
                        <tr>
                        <th width="40px"><a href="#">ID<img src="img/icons/arrow_down_mini.gif" width="16" height="16" align="absmiddle" /></a></th>
                        <th><a href="#">チーム名</a></th>
                        <th width="100px"><a href="#">対戦希望日</a></th>
                        <th width="100px"><a href="#">時間帯</a></th>
                        <th width="190px"><a href="#">場所</a></th>
                        <th width="100px"><a href="#">状況</a></th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach( $collects as $collect ) : ?>
                        <tr>
                            <td class="a-center">
                                <a href=""><?php echo h( $collect['id'] );?></a>
                            </td>
                            <td><a href="#"><?php echo h( $collect['name'] ) ?></a></td>
                            <td><?php echo h( $collect['day'] ); ?></td>
                            <td><?php echo h( $collect['time'] ) ?></td>
                            <td><?php echo h( $collect['locate'] ) ?></td>
                            <td>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                    </tbody>
                    </table>

                    <!-- pager -->
                    <div id="pager">
                        Page 
                        <a href="#"><img src="/img/icons/arrow_left.gif" width="16" height="16" /></a> 
                        <input size="1" value="1" type="text" name="page" id="page" /> 
                        <a href="#"><img src="/img/icons/arrow_right.gif" width="16" height="16" /></a>of 42
                    pages 
                     | Total <strong>420</strong> 
                    </div>
                    <!-- /pager -->

                    <div id="pager">

全<?php echo $pager['total_count']?>件
    <?php echo $pager['curpage']?>/全<?php echo $pager['total_pages']?>ページ<br />

<?php if ($pager['first_group']) : ?>
    <a href="/collects/index?page=<?php echo "1"; ?>">First</a>
<?php endif; ?>

<?php if ($pager['prev']) : ?>
    <a href="/collects/index?page=<?php echo $pager['prev'] ;?>" >＜</a>
<?php endif; ?>

<?php for( $i=$pager['start_page']; $i<=$pager['end_page']; $i++ ): ?>
    <a href="/collects/index?page=<?php echo $i; ?>"><?php echo $i ;?></a>
<?php endfor; ?>

<?php if ($pager['next']) : ?>
    <a href="/collects/index?page=<?php echo $pager['next']; ?>">＞</a>
<?php endif; ?>

<?php if ($pager['last_group']) : ?>
    <a href="/collects/index?page=<?php echo $pager['last_group']?>">Last</a>
<?php endif; ?>

                    </div>

                    <?php endif; ?>
                </div>
                <!-- /box  -->

           </div>
           <!-- /content -->

           <!-- sidebar -->
           <div id="sidebar">
               <h3 class="a-center"><a href="/collects/add">募集をする</a></h3>
           </div>
           <!-- /sidebar -->
