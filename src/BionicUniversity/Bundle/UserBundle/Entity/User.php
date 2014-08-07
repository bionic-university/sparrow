<?php

namespace BionicUniversity\Bundle\UserBundle\Entity;

use BionicUniversity\Bundle\CommunityBundle\Entity\Community;
use Doctrine\Common\Collections\ArrayCollection;
use BionicUniversity\Bundle\WallBundle\Entity\Post;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * User
 */
class User extends BaseUser
{
    const GENDER_MALE = 'm';
    const GENDER_FEMALE = 'f';

    const ROLE_01 = 'User';
    const ROLE_02 = 'Admin';
    /**
     * @var integer
     * @Assert\Type(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @Assert\Length(
     *      max = "255000",
     *      )
     */
    private $avatar;

    /**
     * @var string
     * @Assert\Type(
     *      type="string",
     *      message="These data must be a string"
     *      )
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Your first name must be at least 2 characters length",
     *      maxMessage = "Your first name cannot be longer than 50 characters length"
     *      )
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @var string
     * @Assert\Type(
     *      type="string",
     *      message="These data must be a string"
     *      )
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Your last name must be at least 2 characters length",
     *      maxMessage = "Your last name cannot be longer than 50 characters length"
     *      )
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @var string
     * @Assert\Type(
     *      type="string",
     *      message="These data must be a string"
     *      )
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Your position must be at least 2 characters length",
     *      maxMessage = "Your position cannot be longer than 50 characters length"
     *      )
     * @Assert\NotBlank()
     */
    private $position;

    /**
     * @var Department
     *
     * @Assert\NotBlank()
     */
    private $department;

    /**
     * @var string
     * @Assert\Choice(
     *      choices = { "m", "f" },
     *      message = "Choose a valid gender."
     *      )
     * @Assert\NotBlank()
     */
    private $gender;

    /**
     * @var string
     * @Assert\Length(
     *      max = "1000",
     *      maxMessage="Permissible length of the story itself is 1000 characters"
     *      )
     */
    private $aboutMe;


    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @Assert\NotBlank()
     */
    private $joined;

    /**
     * @return \DateTime
     */
    public function getJoined()
    {
        return $this->joined;
    }

    /**
     * @param string $aboutMe
     */
    public function setAboutMe($aboutMe)
    {
        $this->aboutMe = $aboutMe;
    }

    /**
     * @return string
     */
    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    /**
     * @var ArrayCollection
     * @Assert\NotBlank()
     */
    private $incomingMessages;

    /**
     * @var ArrayCollection
     * @Assert\NotBlank()
     *
     */
    private $outcomingMessages;

    /**
     * @var ArrayCollection
     */
    private $posts;

    /**
     * @var ArrayCollection
     */
    private $memberships;

    /**
     * @var ArrayCollection
     */
    private $myCommunities;
    /**
     * @var ArrayCollection
     */
    private $requests;

    /**
     * @var ArrayCollection
     */
    private $invites;

    /**
     * @var string
     * @Assert\Length(max = "15", maxMessage="This value cannot be greater than 15 characters")
     * @Assert\NotBlank()
     */
    private $phoneNumber;

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }


    /**
     * @var \DateTime
     * @Assert\Date(
     *      message = "This value must be YYYY-MM-DD format"
     *      )
     * @Assert\NotBlank(
     *      message = "This value should not be blank"
     *      )
     */
    private $dateOfBirth;

    public function __construct()
    {
        parent::__construct();
        $this->posts = new ArrayCollection();
        $this->incomingMessages = new ArrayCollection();
        $this->outcomingMessages = new ArrayCollection();
        $this->memberships = new ArrayCollection();
        $this->requests = new ArrayCollection();
        $this->invites = new ArrayCollection();
        $this->groups = ['ROLE_USER'];
        $this->roles = ['ROLE_USER'];
        $this->interests = new ArrayCollection();
        $this->myCommunities = new ArrayCollection();
        $this->setEnabled(false);
        $this->joined = new \DateTime();
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getMemberships()
    {
        return $this->memberships;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param  string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param  string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set position
     *
     * @param  string $position
     * @return User
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set department
     *
     * @param  Department $department
     * @return User
     */
    public function setDepartment(Department $department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getIncomingMessages()
    {
        return $this->incomingMessages;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOutcomingMessages()
    {
        return $this->outcomingMessages;
    }

    /**
     * @return ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Add incomingMessages
     *
     * @param  \BionicUniversity\Bundle\MessageBundle\Entity\Message $incomingMessages
     * @return User
     */
    public function addIncomingMessage($incomingMessages)
    {
        $this->incomingMessages[] = $incomingMessages;

        return $this;
    }

    /**
     * Remove incomingMessages
     *
     * @param \BionicUniversity\Bundle\MessageBundle\Entity\Message $incomingMessages
     */
    public function removeIncomingMessage($incomingMessages)
    {
        $this->incomingMessages->removeElement($incomingMessages);
    }

    /**
     * Add outcomingMessages
     *
     * @param  \BionicUniversity\Bundle\MessageBundle\Entity\Message $outcomingMessages
     * @return User
     */
    public function addOutcomingMessage($outcomingMessages)
    {
        $this->outcomingMessages[] = $outcomingMessages;

        return $this;
    }

    /**
     * Remove outcomingMessages
     *
     * @param \BionicUniversity\Bundle\MessageBundle\Entity\Message $outcomingMessages
     */
    public function removeOutcomingMessage($outcomingMessages)
    {
        $this->outcomingMessages->removeElement($outcomingMessages);
    }

    public function addMyCommunities(Community $community)
    {
        $this->myCommunities[] = $community;

        return $this;
    }

    /**
     * Remove posts
     * @param Post $post
     */
    public function removeMyCommunities(Community $community)
    {
        $this->myCommunities->removeElement($community);
    }

    /**
     * Add posts
     * @param  Post $post
     * @return Post
     */
    public function addPost(Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove posts
     * @param Post $post
     */
    public function removePosts(Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Add memberships
     *
     * @param  \BionicUniversity\Bundle\UserBundle\Entity\User $memberships
     * @return User
     */
    public function addMembership($memberships)
    {
        $this->memberships[] = $memberships;

        return $this;
    }

    /**
     * Remove memberships
     *
     * @param \BionicUniversity\Bundle\UserBundle\Entity\User $memberships
     */
    public function removeMembership(\BionicUniversity\Bundle\UserBundle\Entity\User $memberships)
    {
        $this->memberships->removeElement($memberships);
    }

    /**
     * Set dateOfBirth
     *
     * @param  \DateTime $dateOfBirth
     * @return User
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $interests;

    /**
     * Remove post
     *
     * @param \BionicUniversity\Bundle\WallBundle\Entity\Post $post
     */
    public function removePost(\BionicUniversity\Bundle\WallBundle\Entity\Post $post)
    {
        $this->post->removeElement($post);
    }

    /**
     * Get post
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Add interests
     *
     * @param  \BionicUniversity\Bundle\UserBundle\Entity\Interest $interests
     * @return User
     */
    public function addInterest(\BionicUniversity\Bundle\UserBundle\Entity\Interest $interests)
    {
        $this->interests[] = $interests;

        return $this;
    }

    /**
     * Remove interests
     *
     * @param \BionicUniversity\Bundle\UserBundle\Entity\Interest $interests
     */
    public function removeInterest(\BionicUniversity\Bundle\UserBundle\Entity\Interest $interests)
    {
        $this->interests->removeElement($interests);
    }

    /**
     * Get interests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * Add requests
     *
     * @param  \BionicUniversity\Bundle\UserBundle\Entity\Friendship $requests
     * @return User
     */
    public function addRequest(\BionicUniversity\Bundle\UserBundle\Entity\Friendship $requests)
    {
        $this->requests[] = $requests;

        return $this;
    }

    /**
     * Remove requests
     *
     * @param \BionicUniversity\Bundle\UserBundle\Entity\Friendship $requests
     */
    public function removeRequest(\BionicUniversity\Bundle\UserBundle\Entity\Friendship $requests)
    {
        $this->requests->removeElement($requests);
    }

    /**
     * Get requests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * Add invites
     *
     * @param  \BionicUniversity\Bundle\UserBundle\Entity\Friendship $invites
     * @return User
     */
    public function addInvite(\BionicUniversity\Bundle\UserBundle\Entity\Friendship $invites)
    {
        $this->invites[] = $invites;

        return $this;
    }

    /**
     * Remove invites
     *
     * @param \BionicUniversity\Bundle\UserBundle\Entity\Friendship $invites
     */
    public function removeInvite(\BionicUniversity\Bundle\UserBundle\Entity\Friendship $invites)
    {
        $this->invites->removeElement($invites);
    }

    /**
     * Get invites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvites()
    {
        return $this->invites;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return (null !== $this->avatar) ? $this->avatar : 'no_avatar.jpg';
    }

    public function getFullAvatar()
    {
        return sprintf('/uploads/avatar/%s', $this->getAvatar());
    }

    public function hasRequest(User $user)
    {
        return count($this->getFriendships()->filter(function ($element) use ($user) {
            /** @var Friendship $element */
            return $element->getUserReceiver()->getId() === $user->getId();
        })) > 0;
    }

    public function isFriendOf(User $user)
    {
        return count($this->getFriends()->filter(function ($element) use ($user) {
            /** @var Friendship $element */
            return $element->getUserReceiver()->getId() === $user->getId()
            || $element->getUserSender()->getId() === $user->getId();
        })) > 0;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection|ArrayCollection
     */
    public function getFriendships()
    {
        $friendships = new ArrayCollection(array_merge($this->invites->toArray(), $this->requests->toArray()));
        return $friendships->filter(function ($element) {

            /**@var Friendship $element */
            return $element->getAcceptanceStatus() === Friendship::UNCONFIRMED;
        });
    }

    /**
     * @return \Doctrine\Common\Collections\Collection|ArrayCollection
     */
    public function getFriends()
    {
        $friendships = new ArrayCollection(array_merge($this->invites->toArray(), $this->requests->toArray()));
        return $friendships->filter(function ($element) {

            /**@var Friendship $element */
            return $element->getAcceptanceStatus() === Friendship::CONFIRMED;
        });
    }

    public function hasInvited(User $user)
    {
        return count($this->requests->filter(function ($element) use ($user) {
            return $element->getUserReceiver()->getId() === $user->getId() && $element->getAcceptanceStatus() === Friendship::UNCONFIRMED;
        }));
    }

    public function wasInvitedBy(User $user)
    {
        return count($this->invites->filter(function ($element) use ($user) {
            return $element->getUserSender()->getId() === $user->getId() && $element->getAcceptanceStatus() === Friendship::UNCONFIRMED;
        }));
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $myCommunities
     */
    public function setMyCommunities($myCommunities)
    {
        $this->myCommunities = $myCommunities;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getMyCommunities()
    {
        return $this->myCommunities;
    }

    /**
     * Returns the user roles
     *
     * @return array The roles
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
