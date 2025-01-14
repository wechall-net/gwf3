<?php
final class Comments_Delete extends GWF_Method
{
	public function execute()
	{
		if (false === ($comment = GWF_Comment::getByID(Common::getGetString('cmt_id'))))
		{
			return $this->module->error('err_comment');
		}

		if (false === ($comments = $comment->getComments()))
		{
			return $this->module->error('err_comments');
		}
		
		if (!$comments->canModerate(GWF_Session::getUser()))
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false === $comment->onDelete())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->module->message('msg_deleted');
	}
}
?>
