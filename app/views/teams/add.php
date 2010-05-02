
           <div id="noside_content">

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
                    <h3 id="adduser">チーム登録</h3>
                    <form id="form" action="/teams/create" method="post">
                      <fieldset id="personal">
                        <legend>チーム情報</legend>
                        <label for="login_id">ログインID: </label> 
                        <input name="team/login_id" id="login_id" type="text" tabindex="1" value="<?php echo $data['login_id']; ?>" />

                        <br />
                        <label for="name">チーム名: </label>
                        <input name="team/name" id="name" type="text" 
                        tabindex="2" value="<?php echo $data['name']  ?>" />
                        <br />
                        <label for="email">Email : </label>
                        <input name="team/email" id="email" type="text" 
                        tabindex="3" value="<?php echo $data['email']; ?>" />
                        <br />

                        <label for="password">パスワード: </label>
                        <input name="team/password" id="password" type="password" 
                        tabindex="4" value="<?php echo $data['password']; ?>" />
                        <br />
                        <label for="password-2">パスワード確認: </label>
                        <input name="team/password-2" id="password-2" type="password" 
                        tabindex="5" value="<?php echo $data['password-2'] ?>" />
                        <br />
                      </fieldset>
                      <fieldset id="address">

                        <legend>住所</legend>
                        <label for="prefcture_id">都道府県: </label>
                        <?php echo $this->html->selectTag( $this->prefecture->getPrefectures() , 'team/prefecture_id', $data['prefecture_id'] ); ?>

                      </fieldset>
                      <div align="center">
                      <input id="button1" type="submit" value="送信" /> 
                      <input id="button2" type="reset" />
                      </div>
                    </form>

                </div>

            </div>
