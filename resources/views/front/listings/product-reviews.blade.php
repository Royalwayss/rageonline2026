<!-- reviews section -->
<div class="container write-review-section">
   <h3 class="text-center mb-5">Write a Review</h3>
   <form class="row g-4 bg-light p-4 rounded shadow-sm" id="save-review" action="javascript:;" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="product_id" value="{{ $productdetails['id'] }}">
      <!-- Rating -->
      <div class="col-12 text-center mt-0">
         <label class="form-label fw-bold">Rating</label>
         <div class="star-rating d-inline-block" id="starRating">
            <span class="star" data-value="1">★</span>
            <span class="star" data-value="2">★</span>
            <span class="star" data-value="3">★</span>
            <span class="star" data-value="4">★</span>
            <span class="star" data-value="5">★</span>
         </div>
         <input type="hidden" id="ratingValue" name="rating">
         <p class="error-message" id="review-rating" ></p>
      </div>
      <!-- Review Title & Content -->
      <div class="col-md-6">
         <label class="form-label">Review Title</label>
         <input type="text" class="form-control" id="reviewTitle" name="review_title" placeholder="Give your review a title" >
         <p class="error-message" id="review-review_title" ></p>
      </div>
      <div class="col-md-6">
         <label class="form-label">Review Content</label>
         <textarea class="form-control" id="reviewContent" name="review_content" rows="2" placeholder="Write your review..." ></textarea>
         <p class="error-message" id="review-review_content" ></p>
      </div>
      <!-- Picture/Video Upload -->
      <div class="col-md-6">
         <label class="form-label">Pictures (optional)</label>
         <div class="upload-box">
            <input type="file" name="file[]" id="fileUpload" accept="image/*" multiple onchange="previewImages(event)">
            <label for="fileUpload" class="d-block">Click to Upload Multiple</label>
            <div id="previewContainer" class="preview-container"></div>
         </div>
      </div>
      <!-- Display Name & Email -->
      <div class="col-md-6">
         <label class="form-label">Display Name</label>
         <input type="text" class="form-control" id="displayName" name="display_name" placeholder="John Smith" >
         <p class="error-message" id="review-display_name" ></p>
         <label class="form-label mt-3">Email Address</label>
         <input type="text" class="form-control" id="email" name="email"  placeholder="your@email.com" >
         <p class="error-message" id="review-email" ></p>
      </div>
      <!-- Submit -->
      <div class="col-12 text-center">
         <button type="submit" class="submitBtn">Submit Review</button>
      </div>
   </form>
   @if(count($productdetails['product_reviews']) > 0)
   <!-- Display submitted reviews -->
   <div class="mt-5" id="reviewsList">
      <h4 class="mb-4 text-uppercase">Customer Reviews</h4>
      @foreach($productdetails['product_reviews'] as $product_review)
      <div class="customer-review">
         <!-- Example Review 1 -->
         <div class="review-item">
            <h5>{{ $product_review['display_name'] }}</h5>
              <p>  <?php for($rating=1; $rating<($product_review['rating']+1);$rating++ ){  echo '★'; } ?> </p>
            <strong>{{ $product_review['review_title'] }}</strong>
            <p>@php echo $product_review['review_content']; @endphp</p>
            <?php 
               if($product_review['images'] != ''){
                             $explode_images = explode(',',$product_review['images']);
                ?>
            <div class="review-images">
               @foreach($explode_images as $review_img)
               <img src="{{ asset('images/ProductImages/review/'.$review_img) }}" alt="review image" style="max-width:100px;">
               @endforeach
            </div>
            <?php } ?>
         </div>
         @endforeach
      </div>
   </div>
   @endif
</div>
<!-- reviews section end-->