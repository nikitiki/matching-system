
            <!-- content -->
            <div id="content">

                <?php /* エラーがあれば出力  */ ?>
                <?php if( isset( $error_msgs ) && !empty( $error_msgs ) ):?>
                    <?php $this->form->errors( $error_msgs ); ?>
                <?php endif; ?>

                <!-- box -->
                <div id="box">

                    <h3>募集する</h3>
                    <form id="form" action="/collects/create" method="post">

                        <fieldset id="">

                            <legend>募集情報</legend>
                            <label for="day">対戦したい日: </label>
                            <?php echo $this->form->timeSelectTag( array( 'name' => 'year', 'min' => 0, 'max' => 1 ), 'collect/year', $data['year'], array( 'style' => 'margin-bottom: 5px;' ) ); ?>

                            年&nbsp;

                            <?php echo $this->form->timeSelectTag( array( 'name' => 'month' ), 'collect/month', $data['month'], array( 'style' => 'margin-bottom: 5px' ) ); ?>
                            月&nbsp;

                            <?php echo $this->form->timeSelectTag( array( 'name' => 'day' ), 'collect/day', $data['day'], array( 'style' => 'margin-bottom: 5px;' ) ); ?>
                            日
                            <br />

                            <label for="time">時間帯とか: </label>
                            <input type="text" name="collect/time" id="time" value="<?php echo $data['time'] ; ?>" />
                            （特に指定がない場合は「いつでも」や「要相談」などを記入してください）
                            <br />


                            <label for="locate">場所とか: </label>
                            <input type="text" name="collect/locate" id="locate" value="" style="width: 414px" />

                            <label for="note">なんでも<br />書いていいよ: </label><?php echo $data['note'] ?>
                            <textarea name="collect/note" id="note" style="vertical-align: top"></textarea>（例：料金のこととか）
                        </fieldset>

                        <div align="center">
                            <input id="button1" type="submit" value="送信" />
                            <input id="button2" type="reset" />
                        </div>

                    </form>
                </div>
                <!-- /box -->

            </div>
            <!-- content -->
