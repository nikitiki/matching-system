
               <?php /* エラーメッセージ出力  */ ?>
               <?php if( $error_msgs ) : ?>
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
                        <input name="team/login_id" id="login_id" type="text" tabindex="1" />

                        <br />
                        <label for="name">チーム名: </label>
                        <input name="team/name" id="name" type="text" 
                        tabindex="2" />
                        <br />
                        <label for="email">Email : </label>
                        <input name="team/email" id="email" type="text" 
                        tabindex="2" />
                        <br />

                        <label for="pass">パスワード: </label>
                        <input name="team/pass" id="pass" type="password" 
                        tabindex="2" />
                        <br />
                        <label for="pass-2">パスワード確認: </label>
                        <input name="team/pass-2" id="pass-2" type="password" 
                        tabindex="2" />
                        <br />
                      </fieldset>
                      <fieldset id="address">

                        <legend>住所</legend>
                        <label for="pref">都道府県: </label>
                        <select name="pref">

                            <option label="1" value="1">北海道
                            </option>
                        </select>

                      </fieldset>
                      <div align="center">
                      <input id="button1" type="submit" value="送信" /> 
                      <input id="button2" type="reset" />
                      </div>
                    </form>

                </div>
