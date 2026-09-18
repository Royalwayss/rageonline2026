<?php
    $reviews = $productdetails['product_reviews'];
    $review_count = count($reviews);

    $star_counts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
    $rating_sum = 0;

    foreach ($reviews as $r) {
        $rating_rounded = (int) round($r['rating']);
        if ($rating_rounded >= 1 && $rating_rounded <= 5) {
            $star_counts[$rating_rounded]++;
        }
        $rating_sum += $r['rating'];
    }

    $average_rating = $review_count > 0 ? round($rating_sum / $review_count, 1) : 0;
?>

<section class="product-reviews-section" id="productReviewsSection">
    <div class="container-fluid">

        <div class="related-head">
            <span>Verified Feedback</span>
            <h2>Customer Reviews</h2>
        </div>

        <div class="review-summary">
            <div class="row">

                <div class="col-lg-4 col-md-5 col-12">
                    <div class="rating-overview">

                        <strong>{{ $average_rating }}</strong>

                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($average_rating))
                                    <i class="fa-solid fa-star"></i>
                                @elseif($i - $average_rating < 1)
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                @else
                                    <i class="fa-regular fa-star"></i>
                                @endif
                            @endfor
                        </div>

                        <p>Based on {{ $review_count }} {{ $review_count == 1 ? 'review' : 'reviews' }}</p>

                    </div>
                </div>

                <div class="col-lg-5 col-md-7 col-12">
                    <div class="rating-bars">

                        @for($star = 5; $star >= 1; $star--)
                            <?php $star_percent = $review_count > 0 ? round(($star_counts[$star] / $review_count) * 100) : 0; ?>
                            <div class="rating-row">
                                <span>{{ $star }}</span>
                                <i class="fa-solid fa-star"></i>
                                <div class="rating-line">
                                    <span style="width: {{ $star_percent }}%;"></span>
                                </div>
                                <small>{{ $star_counts[$star] }}</small>
                            </div>
                        @endfor

                    </div>
                </div>

                <div class="col-lg-3 col-md-12 col-12">
                    <div class="write-review-wrap">
                        <p>Have you purchased this piece?</p>
                        <button type="button" class="write-review-btn" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            Write A Review
                        </button>
                    </div>
                </div>

            </div>
        </div>


        @if($review_count > 0)
        <div class="review-list" id="reviewsList">

            @foreach($reviews as $product_review)
            <div class="review-item">

                <div class="review-meta">
                    <strong>{{ $product_review['display_name'] }}</strong>
                    @if(!empty($product_review['created_at']))
                        <small>{{ date('d M Y', strtotime($product_review['created_at'])) }}</small>
                    @endif
                </div>

                <div class="review-stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $product_review['rating'])
                            <i class="fa-solid fa-star"></i>
                        @else
                            <i class="fa-regular fa-star"></i>
                        @endif
                    @endfor
                </div>

                @if(!empty($product_review['review_title']))
                <h4>{{ $product_review['review_title'] }}</h4>
                @endif

                <p>{{ $product_review['review_content'] }}</p>

                @if(!empty($product_review['images']))
                <?php $explode_images = explode(',', $product_review['images']); ?>
                <div class="review-images">
                    @foreach($explode_images as $review_img)
                    <a href="{{ asset('images/ProductImages/review/'.$review_img) }}" data-fancybox="review-images">
                        <img src="{{ asset('images/ProductImages/review/'.$review_img) }}" alt="review image">
                    </a>
                    @endforeach
                </div>
                @endif

            </div>
            @endforeach

        </div>
        @endif

    </div>
</section>


<!-- WRITE A REVIEW MODAL -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content review-modal-content">

            <div class="modal-header">
                <div>
                    <span>Share Your Experience</span>
                    <h4 class="modal-title" id="reviewModalLabel">Write A Review</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <form id="save-review" action="javascript:;" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $productdetails['id'] }}">

                    <div class="review-field">
                        <label>Your Rating</label>

                        <div class="review-stars-input" id="starRating">
                            <span class="star" data-value="5"><i class="fa-regular fa-star"></i></span>
                            <span class="star" data-value="4"><i class="fa-regular fa-star"></i></span>
                            <span class="star" data-value="3"><i class="fa-regular fa-star"></i></span>
                            <span class="star" data-value="2"><i class="fa-regular fa-star"></i></span>
                            <span class="star" data-value="1"><i class="fa-regular fa-star"></i></span>
                        </div>
                        <input type="hidden" id="ratingValue" name="rating">
                        <p class="error-message" id="review-rating"></p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="review-field">
                                <label>Name</label>
                                <input type="text" class="form-control" id="displayName" name="display_name" placeholder="Your Name">
                                <p class="error-message" id="review-display_name"></p>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="review-field">
                                <label>Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Your Email">
                                <p class="error-message" id="review-email"></p>
                            </div>
                        </div>
                    </div>

                    <div class="review-field">
                        <label>Review Title</label>
                        <input type="text" class="form-control" id="reviewTitle" name="review_title" placeholder="Summarise your experience">
                        <p class="error-message" id="review-review_title"></p>
                    </div>

                    <div class="review-field">
                        <label>Your Review</label>
                        <textarea class="form-control" id="reviewContent" name="review_content" rows="4" placeholder="Tell us what you think about this product"></textarea>
                        <p class="error-message" id="review-review_content"></p>
                    </div>

                    <div class="review-field">
                        <label>Pictures (optional)</label>
                        <div class="upload-box">
                            <input type="file" name="file[]" id="fileUpload" accept="image/*" multiple>
                            <label for="fileUpload" class="d-block">Click to Upload</label>
                            <div id="previewContainer" class="preview-container"></div>
                        </div>
                    </div>

                    <button type="submit" class="review-submit-btn">
                        Submit Review
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>
