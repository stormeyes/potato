<form action='/add' method='POST'>
    分类<input type='text' name='category'><br>
    题目<input type='text' name='content'><br>
    A<input type='text' name='optionA'><br>
    B<input type='text' name='optionB'><br>
    C<input type='text' name='optionC'><br>
    D<input type='text' name='optionD'><br>
    答案<input type='text' name='answer'><br>
    <input type='submit'>
</form>

<table>
                      <thead>
                         <tr>
                            <th>id</th>
                            <th>分类</th>
                            <th>题目</th>
                            <th>A</th>
                            <th>B</th>
                            <th>C</th>
                            <th>D</th>
                            <th>答案</th>
                         </tr>
                      </thead>
                      <tbody>
                       <?php foreach($params as $single){ ?>
                        <tr>
                            <td><?php echo $single['id'] ?></td>
                            <td><?php echo $single['category'] ?></td>
                            <td><?php echo $single['content'] ?></td>
                            <td><?php echo $single['optionA'] ?></td>
                            <td><?php echo $single['optionB'] ?></td>
                            <td><?php echo $single['optionC'] ?></td>
                            <td><?php echo $single['optionD'] ?></td>
                            <td><?php echo $single['answer'] ?></td>
                        </tr>
                       <?php } ?>
                      </tbody>
                   </table>
