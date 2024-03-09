<?php
  $term_id = $tag -> $term_id;
  $image = get_term_meta($tag->$term_id,'image',true);
?>
<tr class="form-field">
  <th>Image</th>
  <td>
    <input type="text" name="image" id="image" value="<?= $image; ?>" size="40">
  </td>
</tr>