
                <div id="box">
                    <h3>Teams</h3>

                    <?php if( !empty( $teams ) ): ?>

                    <table width="100%">
                        <thead>
                            <tr>
                                <th width="40px"><a href="#">ID<img src="img/icons/arrow_down_mini.gif" width="16" height="16" align="absmiddle" /></a></th>
                                <th><a href="#">チーム名</a></th>
                                <th width="100px"><a href="#">都道府県</a></th>

                                <th width="190px"><a href="#">付近</a></th>
                                <th width="100px"><a href="#">ステータス</a></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach( $teams as $team ) : ?>

                            <tr>
                                <td class="a-center">232</td>

                                <td><a href="#"><?php echo $team['name'] ?></a></td>
                                <td>General</td>
                                <td>July 2, 2008</td>
                                <td>
                                    <a href="#">
                                        <img src="img/icons/user.png" title="Show profile" width="16" height="16" />
                                    </a>
                                </td>

                            </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>
                    <div id="pager">
                        Page <a href="#"><img src="img/icons/arrow_left.gif" width="16" height="16" /></a> 
                        <input size="1" value="1" type="text" name="page" id="page" /> 
                        <a href="#"><img src="img/icons/arrow_right.gif" width="16" height="16" /></a>of 42
                    pages | View <select name="view">
                                    <option>10</option>

                                    <option>20</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select> 
                    per page | Total <strong>420</strong> records found
                    </div>

                    <?php endif; ?>

                </div>

           
