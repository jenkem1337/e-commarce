<?php

class CommentRepositoryImpl implements CommentRepository {
    private CommentDao $commentDao;
    private CommentFactory $commentFactory;

    function __construct(CommentDao $commentDao, Factory $commentFactory)
    {
        $this->commentDao = $commentDao;
        $this->commentFactory = $commentFactory;
    }
    function persist(Comment $c)
    {
        $this->commentDao->persist($c);
    }
    function findAll():IteratorAggregate
    {
        $commentObjects = $this->commentDao->findAll();
        $commentArray = new CommentCollection();
        foreach($commentObjects as $commentObject){
            $commentDomainObject = $this->commentFactory->createInstance(
                false,
                $commentObject->uuid,
                $commentObject->product_uuid,
                $commentObject->user_uuid,
                $commentObject->comment_text,
                $commentObject->created_at,
                $commentObject->updated_at
            );
            $commentArray->add($commentDomainObject);
        }
        return $commentArray;
    }
    function findAllByUserUuid($userUuid):IteratorAggregate {
        $commentObjects = $this->commentDao->findAllByUserUuid($userUuid);
        $commentArray = new CommentCollection();
        foreach($commentObjects as $commentObject){
            $commentDomainObject = $this->commentFactory->createInstance(
                false,
                $commentObject->uuid,
                $commentObject->product_uuid,
                $commentObject->user_uuid,
                $commentObject->comment_text,
                $commentObject->created_at,
                $commentObject->updated_at
            );
            $commentArray->add($commentDomainObject);
        }
        return $commentArray;
    }
    function findAllByProductUuid($productUuid): IteratorAggregate
    {
        $commentObjects = $this->commentDao->findAllByProductUuid($productUuid);
        $commentArray = new CommentCollection();
        foreach($commentObjects as $commentObject){
            $commentDomainObject = $this->commentFactory->createInstance(
                false,
                $commentObject->uuid,
                $commentObject->product_uuid,
                $commentObject->user_uuid,
                $commentObject->comment_text,
                $commentObject->created_at,
                $commentObject->updated_at
            );
            if(!$commentDomainObject->isNull()){
                $commentArray->add($commentDomainObject);
            }
        }
        return $commentArray;
    }
    function findOneByUuid($uuid): CommentInterface
    {
        $commentObject = $this->commentDao->findOneByUuid($uuid);
        $commentDomainObject = $this->commentFactory->createInstance(
            false,
            $commentObject->uuid,
            $commentObject->product_uuid,
            $commentObject->user_uuid,
            $commentObject->comment_text,
            $commentObject->created_at,
            $commentObject->updated_at
        );
        return $commentDomainObject;
    }
    function deleteByUuid($uuid)
    {
        $this->commentDao->deleteByUuid($uuid);
    }
    function updateByUuid(Comment $c)
    {
        $this->commentDao->updateByUuid($c);
    }
    function setProductMediator(AbstractProductRepositoryMediatorComponent $mediator)
    {
        $mediator->setCommentRepository($this);
    }
}