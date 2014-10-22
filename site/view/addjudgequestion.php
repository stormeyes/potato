<form action='/add/judge' method='POST'>
    分类<input type='text' name='category'><br>
    题目<input type='text' name='content'><br>
    答案(1或者0)<input type='text' name='answer'><br>
    <input type='submit'>
</form>

<table>
                      <thead>
                         <tr>
                            <th>id</th>
                            <th>分类</th>
                            <th>题目</th>
                            <th>答案</th>
                         </tr>
                      </thead>
                      <tbody>
                       <?php foreach($params as $single){ ?>
                        <tr>
                            <td><?php echo $single['id'] ?></td>
                            <td><?php echo $single['category'] ?></td>
                            <td><?php echo $single['content'] ?></td>
                            <td><?php echo $single['answer'] ?></td>
                        </tr>
                       <?php } ?>
                      </tbody>
                   </table>
