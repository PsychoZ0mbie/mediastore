<?php
    headerPage($data);
    $article = $data['article'];
    $categories = $data['categories'];
    $recPosts = $data['recPosts'];
    $relPosts = $data['relPosts'];
?>
<main class="addFilter">
    <div class="container">
        <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>/blog">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page">Article</li>
                <li class="breadcrumb-item active" aria-current="page">Lorem ipsu Tenetur esse ad lorem</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-3">
                <aside class="filter-options p-2">
                <div class="accordion accordion-flush" id="accordionFlushCategories">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-categories">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCategories" aria-expanded="false" aria-controls="flush-collapseCategories">
                            <strong class="fs-5">Categories</strong>
                        </button>
                        </h2>
                        <div id="flush-collapseCategories" class="accordion-collapse collapse show" aria-labelledby="flush-categories" data-bs-parent="#accordionFlushCategories">
                        <div class="accordion-body">
                            <div class="accordion accordion-flush" id="accordionFlushCategorie">
                                <?php
                                    for ($i=0; $i < count($categories) ; $i++) { 
                                        $routeC = base_url()."/blog/category/".$categories[$i]['route'];
                                ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-categorie<?=$i?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCategorie<?=$i?>" aria-expanded="false" aria-controls="flush-collapseCategorie<?=$i?>">
                                    </button>
                                    <a href="<?=$routeC?>" class="text-decoration-none"><?=$categories[$i]['name']?></a>
                                    </h2>
                                    <div id="flush-collapseCategorie<?=$i?>" class="accordion-collapse collapse show" aria-labelledby="flush-categorie<?=$i?>" data-bs-parent="#accordionFlushCategorie<?=$i?>">
                                    <div class="accordion-body">
                                        <ul class="list-group">
                                            <?php
                                                for ($j=0; $j < count($categories[$i]['subcategories']) ; $j++) { 
                                                    $subcategories = $categories[$i]['subcategories'][$j];
                                                    $routeS = base_url()."/blog/category/".$categories[$i]['route']."/".$subcategories['route'];
                                            ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <a href="<?=$routeS?>"><?=$subcategories['name']?></a>
                                                <span class="badge bg-p rounded-pill"><?=$subcategories['total']?></span>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <?php if(!empty($recPosts)>0){?>
                    <div class="featured">
                        <div class="featured-info">
                            <h2 class="fs-5"><strong>Recent posts</strong></h2>
                            <div class="featured-btns">
                                <div class="p-2 featured-btn-left c-p"><i class="fas fa-angle-left"></i></div>
                                <div class="p-2 featured-btn-right c-p"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                        <div class="featured-container-items">
                            <?php 
                            $index = 0;
                            
                            $column=round(count($recPosts)/3);
                            
                            if($column ==0){
                                $column = 1;
                            }
                            
                            for ($i=0; $i < $column ; $i++) { 
                            ?>  
                            <div class="featured-items">
                                <?php for ($j = 0 ;$j < 3 ; $j++) {
                                    if(count($recPosts) > $index){
                                        $routeP = base_url()."/blog/article/".$recPosts[$index]['route'];
                                ?>
                                <div class="featured-item">
                                    <div class="row">
                                        <?php
                                            $routeImg = media()."/images/uploads/category.jpg";
                                            if($recPosts[$index]['picture'] !=""){
                                                $routeImg = media()."/images/uploads/".$recPosts[$index]['picture']; 
                                            }
                                        ?>
                                        <div class="col-4">
                                            <img src="<?=$routeImg?>" alt="<?=$recPosts[$index]['name']?>">
                                        </div>
                                        <div class="col-8">
                                            <div style="height:48px" class="overflow-hidden">
                                                <h3><a href="<?=$routeP?>"><?=$recPosts[$index]['name']?></a></h3>
                                            </div>
                                            <p><?=$recPosts[$index]['date']?></p>
                                        </div>
                                    </div>
                                </div>

                                <?php $index++; }else{ break;} }?>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    <?php }?>
                </aside>
                <div class="filter-options-overlay"></div>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="d-flex align-items-center justify-content-between shop-options">
                    <div class="me-2 c-p" id="filter"><i class="fas fa-filter"></i>Filter</div>
                </div>
                <div class="post">
                    <?php
                        if($article['picture']!=""){
                    ?>
                    <div class="post-cover">
                        <img src="<?=media()."/images/uploads/".$article['picture']?>" alt="<?=$article['name']?>">
                    </div>
                    <?php }?>
                    <div class="post-content">
                        <h1 class="fw-bold t-p"><?=$article['name']?></h1>
                        <div class="d-flex justify-content-between mb-3">
                            <p class="m-0 text-secondary">Last updated on <?=$article['dateupdated']?></p>
                            <a class="text-decoration-none t-p" href="#sharePost">Comments (2)</a>
                        </div>
                        <div>
                            <?=$article['description']?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between position-relative af-t-line mt-4 mb-4" id="sharePost">
                        <div class="mt-2"><i class="fas fa-share"></i> Share this post</div>
                        <div class="mt-2">
                            <a href="#" title="Share on facebook" class="me-2 ms-2 text-dark fs-6"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" title="Share on linkedin" class="me-2 ms-2 text-dark fs-6"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" title="Share on twitter" class="me-2 ms-2 text-dark fs-6"><i class="fab fa-twitter"></i></i></a>
                            <a href="#" title="Share on telegram" class="me-2 ms-2 text-dark fs-6"><i class="fab fa-telegram-plane"></i></i></a>
                        </div>
                    </div>
                    <ul class="comment-list">
                        <li class="comment-block">
                            <div class="comment-img">
                                <img src="https://t4.ftcdn.net/jpg/02/45/56/35/360_F_245563558_XH9Pe5LJI2kr7VQuzQKAjAbz9PAyejG1.jpg" alt="">
                                <p class="text-center fw-bold">29 June 2022</p>
                            </div>
                            <div class="comment-feedb">
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae, deserunt tenetur voluptate quos eligendi sunt alias tempora dolores vitae a dolorum possimus inventore facere, ullam, pariatur repellat provident aliquid error. Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa, officia nesciunt! Eius quam repellendus, voluptate beatae officia asperiores maiores vitae ea facilis sequi, at a ipsa sapiente ipsam in nulla?</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <h3>John Doe</h3>
                                    <p class="m-0 t-p c-p btnAnswer">Show answer <i class="fas fa-angle-down"></i></p>
                                </div>
                            </div>
                            <div class="comment-answer">
                                <p class="m-0">Thanks! Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis perferendis quas optio expedita, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam est animi nostrum aliquid. Cumque, praesentium impedit hic cupiditate ipsum corrupti laboriosam tempora. Similique esse excepturi dicta in qui beatae magni. quidem numquam minima animi adipisci nobis minus consectetur maxime, non eaque maiores molestias, doloribus suscipit aliquid temporibus. Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero eligendi sint itaque tenetur in a cum illum repellendus? Expedita, voluptates. Cum nostrum eum illo cumque vitae iusto eos, nobis libero. consectetur adipisicing elit. Quas ullam deserunt non voluptas quos quisquam? Fugit eveniet mollitia possimus dolorem odio aliquam. Corrupti eveniet beatae nam quasi mollitia soluta excepturi.</p>
                            </div>
                        </li>
                        <li class="comment-block">
                            <div class="comment-img">
                                <img src="data:image/jpeg;base64,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" alt="">
                                <p class="text-center fw-bold">20 June 2022</p>
                            </div>
                            <div class="comment-feedb">
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae, deserunt tenetur voluptate quos eligendi sunt alias tempora dolores vitae a dolorum possimus inventore facere, ullam, pariatur repellat provident aliquid error. Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa, officia nesciunt! Eius quam repellendus, voluptate beatae officia asperiores maiores vitae ea facilis sequi, at a ipsa sapiente ipsam in nulla?</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <h3>Jane Doe</h3>
                                    <p class="m-0 t-p c-p btnAnswer">Show answer <i class="fas fa-angle-down"></i></p>
                                </div>
                            </div>
                            <div class="comment-answer">
                                <p class="m-0">Thanks! Lconsectetur adipisicing elit. Ullamoriosam tempora. Similique esse excepturi dicta in qui beatae magni. quidem numquam minima animi adipisci nobis minus consectetur maxime, non eaque maiores molestias, doloribus suscipit aliquid temporibus. Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero eligendi sint itaque tenetur in a cum illum repellendus? Expedita, voluptates. Cum nostrum eum illo cumque vitae iusto eos, nobis libero. consectetur adipisicing elit. Quas ullam deserunt non voluptas quos quisquam? Fugit eveniet mollitia possimus dolorem odio aliquam. Corrupti eveniet beatae nam quasi mollitia soluta excepturi.</p>
                            </div>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-center mb-3">
                        <form action="" id="formComment" class="w-100">
                            <h3 class="mb-3 text-center">Add your comment</h3>
                            <div class="mb-3">
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="Your comment"></textarea>
                            </div>
                            <button type="submit" class="btn btnc-primary">Post comment</button>
                        </form>
                    </div>
                    <?php if(!empty($relPosts)){?>
                    <div class="row mt-5">
                        <h3 class="t-p mb-3"><strong>RELATED POSTS</strong></h3>
                        <?php 
                        for ($i=0; $i < count($relPosts) ; $i++) { 
                            $routePosts = base_url()."/blog/article/".$relPosts[$i]['route'];
                            $imgPost =media()."/images/uploads/category.jpg";
                            if($relPosts[$i]['picture'] !=""){
                                $imgPost = media()."/images/uploads/".$relPosts[$i]['picture'];
                            }
                        ?>
                        <div class="col-lg-4 col-md-6 mb-3 product-item">
                            <div class="card">
                                <img src="<?=$imgPost?>" style="height:200px;" alt="<?=$relPosts[$i]['name']?>">
                                <div class="card-body" style="height:180px;">
                                    <a href="<?=$routePosts?>" class="text-decoration-none text-dark" style="height:50px;"><h2 class="card-title fs-5" ><?=$relPosts[$i]['name']?></h5></a>
                                    <div class="card-text overflow-hidden" style="height:50px;">
                                        <?=$relPosts[$i]['description']?>
                                    </div>
                                    <a href="<?=$routePosts?>" class="btn btnc-primary mt-1">Read more</a>
                                </div>
                            </div>
                        </div>
                        <?php } }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
    footerPage($data);
?>