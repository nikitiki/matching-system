
            <div id='content'>
                <?php /* エラーメッセージ出力  */ ?>
                <?php if( isset( $error_msgs ) && $error_msgs ) : ?>
                <div id="caution">
                     <p class="error">
                     <?php foreach( $error_msgs as $error_array ):  ?>
                         <?php foreach( $error_array as $error_msg ): ?>
                             <?php echo $error_msg;  ?>
                             <br />
                         <?php endforeach; ?>
                     <?php endforeach; ?>
                     </p>
                </div>
                <?php endif; ?>
                <?php /* /エラーメッセージ  */ ?>

                <div id="box">
                    <form id="form" action="/teams/login" method="post">
                      <fieldset id="personal" >
                        <legend>ログイン</legend>
                        <label for="login_id">ログインID: </label> 
                        <input name="team/login_id" id="login_id" type="text" tabindex="1" value="<?php echo $data['login_id']; ?>" />

                        <br />
                        <label for="password">パスワード: </label>
                        <input name="team/password" id="password" type="password" 
                        tabindex="2" value="<?php echo $data['password']; ?>" />

                        <br />
                        <label for="remember_me">次回から自動的にログイン:</label>
                        <?php echo $this->html->checkbox(
                                array(
                                    'name' => 'remember_me',
                                    'id'   => 'remember_me',
                                    'tablindex' => '3',
                                    'value' => '1'
                                ),
                                isset( $remember_me )
                            );
                        ?>
                      </fieldset>
                      <input id="button1" type="submit" value="ログイン" /> 
                    </form>

                </div>
           </div>
