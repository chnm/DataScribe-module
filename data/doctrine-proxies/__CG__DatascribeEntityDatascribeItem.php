<?php

namespace DoctrineProxies\__CG__\Datascribe\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class DatascribeItem extends \Datascribe\Entity\DatascribeItem implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'dataset', 'item', 'prioritizedBy', 'lockedBy', 'submittedBy', 'reviewedBy', 'prioritized', 'locked', 'submitted', 'reviewed', 'isApproved', 'id', 'syncedBy', 'synced', 'transcriberNotes', 'reviewerNotes'];
        }

        return ['__isInitialized__', 'dataset', 'item', 'prioritizedBy', 'lockedBy', 'submittedBy', 'reviewedBy', 'prioritized', 'locked', 'submitted', 'reviewed', 'isApproved', 'id', 'syncedBy', 'synced', 'transcriberNotes', 'reviewerNotes'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (DatascribeItem $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function setDataset(\Datascribe\Entity\DatascribeDataset $dataset): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDataset', [$dataset]);

        parent::setDataset($dataset);
    }

    /**
     * {@inheritDoc}
     */
    public function getDataset(): \Datascribe\Entity\DatascribeDataset
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDataset', []);

        return parent::getDataset();
    }

    /**
     * {@inheritDoc}
     */
    public function setItem(\Omeka\Entity\Item $item): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setItem', [$item]);

        parent::setItem($item);
    }

    /**
     * {@inheritDoc}
     */
    public function getItem(): \Omeka\Entity\Item
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getItem', []);

        return parent::getItem();
    }

    /**
     * {@inheritDoc}
     */
    public function setPrioritizedBy(\Omeka\Entity\User $prioritizedBy = NULL): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrioritizedBy', [$prioritizedBy]);

        parent::setPrioritizedBy($prioritizedBy);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrioritizedBy(): ?\Omeka\Entity\User
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrioritizedBy', []);

        return parent::getPrioritizedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function setLockedBy(\Omeka\Entity\User $lockedBy = NULL): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLockedBy', [$lockedBy]);

        parent::setLockedBy($lockedBy);
    }

    /**
     * {@inheritDoc}
     */
    public function getLockedBy(): ?\Omeka\Entity\User
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLockedBy', []);

        return parent::getLockedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function setSubmittedBy(\Omeka\Entity\User $submittedBy = NULL): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSubmittedBy', [$submittedBy]);

        parent::setSubmittedBy($submittedBy);
    }

    /**
     * {@inheritDoc}
     */
    public function getSubmittedBy(): ?\Omeka\Entity\User
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSubmittedBy', []);

        return parent::getSubmittedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function setReviewedBy(\Omeka\Entity\User $reviewedBy = NULL): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReviewedBy', [$reviewedBy]);

        parent::setReviewedBy($reviewedBy);
    }

    /**
     * {@inheritDoc}
     */
    public function getReviewedBy(): ?\Omeka\Entity\User
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReviewedBy', []);

        return parent::getReviewedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function setPrioritized(?\DateTime $prioritized): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrioritized', [$prioritized]);

        parent::setPrioritized($prioritized);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrioritized(): ?\DateTime
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrioritized', []);

        return parent::getPrioritized();
    }

    /**
     * {@inheritDoc}
     */
    public function setLocked(?\DateTime $locked): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLocked', [$locked]);

        parent::setLocked($locked);
    }

    /**
     * {@inheritDoc}
     */
    public function getLocked(): ?\DateTime
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLocked', []);

        return parent::getLocked();
    }

    /**
     * {@inheritDoc}
     */
    public function setSubmitted(?\DateTime $submitted): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSubmitted', [$submitted]);

        parent::setSubmitted($submitted);
    }

    /**
     * {@inheritDoc}
     */
    public function getSubmitted(): ?\DateTime
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSubmitted', []);

        return parent::getSubmitted();
    }

    /**
     * {@inheritDoc}
     */
    public function setReviewed(?\DateTime $reviewed): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReviewed', [$reviewed]);

        parent::setReviewed($reviewed);
    }

    /**
     * {@inheritDoc}
     */
    public function getReviewed(): ?\DateTime
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReviewed', []);

        return parent::getReviewed();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsApproved(?bool $isApproved): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsApproved', [$isApproved]);

        parent::setIsApproved($isApproved);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsApproved(): ?bool
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsApproved', []);

        return parent::getIsApproved();
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist(\Doctrine\ORM\Event\LifecycleEventArgs $eventArgs)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'prePersist', [$eventArgs]);

        return parent::prePersist($eventArgs);
    }

    /**
     * {@inheritDoc}
     */
    public function getResourceId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getResourceId', []);

        return parent::getResourceId();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setSyncedBy(\Omeka\Entity\User $syncedBy = NULL): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSyncedBy', [$syncedBy]);

        parent::setSyncedBy($syncedBy);
    }

    /**
     * {@inheritDoc}
     */
    public function getSyncedBy(): ?\Omeka\Entity\User
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSyncedBy', []);

        return parent::getSyncedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function setSynced(?\DateTime $synced): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSynced', [$synced]);

        parent::setSynced($synced);
    }

    /**
     * {@inheritDoc}
     */
    public function getSynced(): ?\DateTime
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSynced', []);

        return parent::getSynced();
    }

    /**
     * {@inheritDoc}
     */
    public function setTranscriberNotes(?string $transcriberNotes): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTranscriberNotes', [$transcriberNotes]);

        parent::setTranscriberNotes($transcriberNotes);
    }

    /**
     * {@inheritDoc}
     */
    public function getTranscriberNotes(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTranscriberNotes', []);

        return parent::getTranscriberNotes();
    }

    /**
     * {@inheritDoc}
     */
    public function setReviewerNotes(?string $reviewerNotes): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReviewerNotes', [$reviewerNotes]);

        parent::setReviewerNotes($reviewerNotes);
    }

    /**
     * {@inheritDoc}
     */
    public function getReviewerNotes(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReviewerNotes', []);

        return parent::getReviewerNotes();
    }

}
