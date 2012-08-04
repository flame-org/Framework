<?php

namespace Flame\Components\Comments;

use	Nette\Application\UI\Form;

/**
* Comments component
*/
class Comment extends \Flame\Application\UI\Control
{

	/**
	 * @var \Flame\Models\Posts\Post $post
	 */
	private $post;

	/**
	 * @var \Flame\Models\Comments\CommentFacade
	 */
	private $commentFacade;

	/**
	 * @param \Nette\ComponentModel\IContainer $parent
	 * @param null $name
	 */
	public function __construct($parent, $name)
	{
		parent::__construct($parent, $name);

		$this->commentFacade = $this->presenter->context->CommentFacade;
	}

	/**
	 * @param \Flame\Models\Posts\Post $post
	 */
	public function setPost(\Flame\Models\Posts\Post $post)
	{
		$this->post = $post;
	}

	public function render()
	{
		$this->template->setFile(__DIR__.'/Comment.latte');
		$this->template->comments = $this->commentFacade->getPublishCommentsInPost($this->post);
		$this->template->render();
	}

	/**
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentAddCommentForm()
	{
		$f = new Form;
		$f->addText('name', 'Your name', 55)
			->addRule(FORM::FILLED, 'Your name is required!')
			->addRule(FORM::MAX_LENGTH, 'Your name cannot be longer than %d chars', 75);

		$f->addText('email', 'Email adress', 55)
			->addRule(FORM::FILLED, 'Email adress is required!')
			->addRule(FORM::EMAIL)
			->addRule(FORM::MAX_LENGTH, 'Your name cannot be longer than %d chars', 100);

		$f->addText('web', 'Website', 55)
			->addRule(FORM::MAX_LENGTH, 'Your name cannot be longer than %d chars', 100);

		$f->addTextArea('content', 'Comment:', 65, 7)
			->addRule(FORM::FILLED, 'Content of comment is required.')
			->addRule(FORM::MAX_LENGTH, 'Comment must be shorter than %d chars.', 1000);

		$f->addSubmit('send', 'Send');
		$f->onSuccess[] = $this->commentFormSubmitted;

        return $f;
	}

	/**
	 * @param \Nette\Application\UI\Form $f
	 * @throws \Nette\InvalidArgumentException
	 */
	public function commentFormSubmitted(Form $f)
	{

		if(!$this->post){
			throw new \Nette\InvalidArgumentException('You must set Post');
		}

		$values = $f->getValues();

		$comment = new \Flame\Models\Comments\Comment($this->post, $values['name'], $values['email'], $values['content']);
		$comment->setWeb($values['web']);
        $this->commentFacade->persist($comment);
		$this->flashMessage('Your comment is waiting for moderation');
		$this->redirect('this');
	}

	/**
	 * @param $url
	 * @return string
	 */
	private function treatUrl($url)
	{
		if(strpos($url, 'http') !== true){
			$url = 'http://' . $url;
		}

		return $url;
	}
}
