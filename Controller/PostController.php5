<?php
namespace Yosimitso\WorkingForumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Yosimitso\WorkingForumBundle\Entity\PostVote;

/**
 * Class ThreadController
 *
 * @package Yosimitso\WorkingForumBundle\Controller
 */
class PostController extends Controller
{
    public function voteUpAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $postId = $request->get('postId');

        $post = $em->getRepository('YosimitsoWorkingForumBundle:Post')->findOneById($postId);
        if (is_null($post))
        {
            return new Response(json_encode(['res' => 'false', 'errMsg' => 'Thread not found'], 500));
        }
        if ($post->getId() == $user->getId())
        {
            return new Response(json_encode(['res' => 'false', 'errMsg' => 'An user can\'t vote for his post'], 500));
        }

        $subforum = $em->getRepository('YosimitsoWorkingForumBundle:Subforum')->findOneById($post->getThread()->getId());

        if (is_null($subforum)) {
            return new Response(json_encode(['res' => 'false', 'errMsg' => 'Internal error'], 500));
        }

        $authorizationChecker = $this->get('yosimitso_workingforum_authorization');
        if (!$authorizationChecker->hasSubforumAccess($subforum)) { // CHECK IF USER HAS AUTHORIZATION TO VIEW THIS THREAD
            return new Response(json_encode(['res' => 'false'], 403));
        }

        $alreadyVoted = $em->getRepository('YosimitsoWorkingForumBundle:PostVote')->findOneBy(['user' => $user, 'post' => $post]);

        if (is_null($alreadyVoted)) {
            $postVote = new PostVote();
            $postVote->setPost($post)
                    ->setUser($user)
                    ->setType(PostVote::VOTE_UP)
                ;

            $post->addVoteUp();

            $em->persist($postVote);
            $em->persist($post);
            $em->flush();

            return new Response(json_encode(['res' => 'true', 'voteUp' => $post->getVoteUp()], 200));
        }
        else {
            return new Response(json_encode(['res' => 'false', 'errMsg' => 'Already voted'], 500));
        }
    }

}