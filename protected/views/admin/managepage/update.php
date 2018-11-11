<h2>ویرایش صفحه <?php echo ' :: '. ($pageViewModel->title) ? $pageViewModel->title : '-'; ?></h2>

<?php $this->renderPartial('_form', array('pageViewModel'=>$pageViewModel)); ?>