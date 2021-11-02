@extends('master')
@section('content')
	<div class="inner-header">
	    <div class="container">
	        <div class="pull-left">
	            <h6 class="inner-title">Product</h6>
	        </div>
	        <div class="pull-right">
	            <div class="beta-breadcrumb font-large">
	                <a href="index.html">Home</a> / <span>Product</span>
	            </div>
	        </div>
	        <div class="clearfix"></div>
	    </div>
	</div>
	<div class="container">
	    <div id="content">
	        <div class="row">
	            <div class="col-sm-9">
	                <div class="row">
	                    <div class="col-sm-4">
	                        <img src="image/product/{{ $product->image }}" alt="">
	                    </div>
	                    <div class="col-sm-8">
	                        <div class="single-item-body">
	                            <p class="single-item-title">{{ $product->name }}</p>
	                            <p class="single-item-price">
	                                @if($product->promotion_price != $product->unit_price)
	                                    <span class="flash-del">${{ number_format($product->unit_price) }}</span>
	                                    <span class="flash-sale">${{ number_format($product->promotion_price) }}</span>
	                                @else
	                                    <span class="flash-sale">${{ number_format($product->unit_price) }}</span>
	                                @endif
	                            </p>
	                        </div>
	                        <div class="clearfix"></div>
	                        <div class="space20">&nbsp;</div>
	                        <div class="single-item-desc">
	                            <p>{{ $product->description }}</p>
	                        </div>
	                        <div class="space20">&nbsp;</div>
	                        <p>Qty:</p>
	                        <div class="single-item-options">
	                            <select class="wc-select" name="qty">
	                                <option value="1">1</option>
	                                <option value="2">2</option>
	                                <option value="3">3</option>
	                                <option value="4">4</option>
	                                <option value="5">5</option>
	                            </select>
	                            <a class="add-to-cart" href="#"><i class="fa fa-shopping-cart"></i></a>
	                            <div class="clearfix"></div>
	                        </div>
	                    </div>
	                </div>
	                <div class="space40">&nbsp;</div>
	                <div class="woocommerce-tabs">
	                    <ul class="tabs">
	                        <li><a href="#tab-description">Description</a></li>
	                        <li><a href="#tab-reviews">Reviews (0)</a></li>
	                    </ul>
	                    <div class="panel" id="tab-description">
	                        {!! $product->description !!}
	                    </div>
	                    <div class="panel" id="tab-reviews">
	                        <p>No Reviews</p>
	                    </div>
	                </div>
	                <div class="space50">&nbsp;</div>
	                <div class="beta-products-list">
	                    <h4>Related Products</h4>
	                    <div class="row">
                        	@php
                        	$i = 0;
                        	@endphp
                        	@foreach($products_related as $product)
                        	@php
                        	$i++;
                        	$is_sale = $product->promotion_price != $product->unit_price;
                        	@endphp
                        	<div class="col-sm-4">
                                <div class="single-item">
                                    @if($is_sale)
                                    <div class="ribbon-wrapper">
                                        <div class="ribbon sale">Sale</div>
                                    </div>
                                    @endif
                                    <div class="single-item-header">
                                        <a href="{{ route('product') . '?id=' . $product->id }}"><img src="image/product/{{ $product->image }}" alt=""></a>
                                    </div>
                                    <div class="single-item-body">
                                        <p class="single-item-title">{{ $product->name }}</p>
                                        <p class="single-item-price">
                                            @if($is_sale)
                                                <span class="flash-del">${{ number_format($product->unit_price) }}</span>
                                                <span class="flash-sale">${{ number_format($product->promotion_price) }}</span>
                                            @else
                                                <span class="flash-sale">${{ number_format($product->unit_price) }}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="single-item-caption">
                                        <a class="add-to-cart pull-left" href="shopping_cart.html"><i class="fa fa-shopping-cart"></i></a>
                                        <a class="beta-btn primary" href="{{ route('product') . '?id=' . $product->id }}">Details <i class="fa fa-chevron-right"></i></a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            @if($i % 3 == 0)
                            <div class="clearfix"></div>
                            @endif;
                            @endforeach
                        </div>
                        <div class="row">{{ $products_related->links() }}</div>
	                </div> <!-- .beta-products-list -->
	            </div>
	            <div class="col-sm-3 aside">
	                <div class="widget">
	                    <h3 class="widget-title">Best Sellers</h3>
	                    <div class="widget-body">
	                        <div class="beta-sales beta-lists">
	                            <div class="media beta-sales-item">
	                                <a class="pull-left" href="product.html"><img src="assets/dest/images/products/sales/1.png" alt=""></a>
	                                <div class="media-body">
	                                    Sample Woman Top
	                                    <span class="beta-sales-price">$34.55</span>
	                                </div>
	                            </div>
	                            <div class="media beta-sales-item">
	                                <a class="pull-left" href="product.html"><img src="assets/dest/images/products/sales/2.png" alt=""></a>
	                                <div class="media-body">
	                                    Sample Woman Top
	                                    <span class="beta-sales-price">$34.55</span>
	                                </div>
	                            </div>
	                            <div class="media beta-sales-item">
	                                <a class="pull-left" href="product.html"><img src="assets/dest/images/products/sales/3.png" alt=""></a>
	                                <div class="media-body">
	                                    Sample Woman Top
	                                    <span class="beta-sales-price">$34.55</span>
	                                </div>
	                            </div>
	                            <div class="media beta-sales-item">
	                                <a class="pull-left" href="product.html"><img src="assets/dest/images/products/sales/4.png" alt=""></a>
	                                <div class="media-body">
	                                    Sample Woman Top
	                                    <span class="beta-sales-price">$34.55</span>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div> <!-- best sellers widget -->
	                <div class="widget">
	                    <h3 class="widget-title">New Products</h3>
	                    <div class="widget-body">
	                        <div class="beta-sales beta-lists">
	                            <div class="media beta-sales-item">
	                                <a class="pull-left" href="product.html"><img src="assets/dest/images/products/sales/1.png" alt=""></a>
	                                <div class="media-body">
	                                    Sample Woman Top
	                                    <span class="beta-sales-price">$34.55</span>
	                                </div>
	                            </div>
	                            <div class="media beta-sales-item">
	                                <a class="pull-left" href="product.html"><img src="assets/dest/images/products/sales/2.png" alt=""></a>
	                                <div class="media-body">
	                                    Sample Woman Top
	                                    <span class="beta-sales-price">$34.55</span>
	                                </div>
	                            </div>
	                            <div class="media beta-sales-item">
	                                <a class="pull-left" href="product.html"><img src="assets/dest/images/products/sales/3.png" alt=""></a>
	                                <div class="media-body">
	                                    Sample Woman Top
	                                    <span class="beta-sales-price">$34.55</span>
	                                </div>
	                            </div>
	                            <div class="media beta-sales-item">
	                                <a class="pull-left" href="product.html"><img src="assets/dest/images/products/sales/4.png" alt=""></a>
	                                <div class="media-body">
	                                    Sample Woman Top
	                                    <span class="beta-sales-price">$34.55</span>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div> <!-- best sellers widget -->
	            </div>
	        </div>
	    </div> <!-- #content -->
	</div> <!-- .container -->
@endsection