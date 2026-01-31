<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Topic;
use App\Models\ArticleType;
use App\Models\ArticleStatus;
use App\Models\Comment;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class HomeController extends Controller
{

    // Chuyển tới màn hình Đăng nhập bằng Google
    public function getGoogleLogin()
    {
        return Socialite::driver('google')->redirect();
    }
    public function getGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->stateless()
                ->user();
        } catch (Exception $e) {
            return redirect()->route('user.dangnhap')->with('warning', 'Lỗi xác thực. Xin vui lòng thử lại!');
        }
        $existingUser = User::where('email', $user->email)->first();
        if ($existingUser) {
            // Nếu người dùng đã tồn tại thì đăng nhập
            Auth::login($existingUser, true);
            return redirect()->route('user.home');
        } else {
            // Nếu chưa tồn tại người dùng thì thêm mới
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'username' => Str::before($user->email, '@'),
                'password' => Hash::make('greentech@2025'), // Gán mật khẩu tự do
            ]);
            // Sau đó đăng nhập
            Auth::login($newUser, true);
            return redirect()->route('user.home');
        }
    }
    // HomeController.php

    public function getHome()
    {
        $categories = Category::with([
            'products' => function ($query) {
                $query->latest()
                    ->with('avatar')
                    ->take(8);
            }
        ])->get();

        $manufactures = Manufacturer::with([
            'products' => function ($query) {
                $query->latest()
                    ->with('avatar')
                    ->take(8);
            }
        ])->get();

        $topics = Topic::with([
            'Article' => function ($query) {
                $query->latest()
                    ->take(8);  
            }
        ])->get();

        $article_types = ArticleType::with([
            'articles' => function ($query) {
                $query->latest()
                    ->take(8);
            }
        ])->get();

        $manufacturesProducts = Product::with(['images', 'manufacturer'])
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $featuredProducts = Product::with(['images', 'category'])
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $typesArticles = Article::with(['ArticleStatus', 'ArticleType','Comments'])
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $featuredArticles = Article::with(['ArticleStatus', 'Topic','Comments'])
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $sliderImages = [];
        foreach ($featuredProducts as $product) {
            $allImages = $product->images->pluck('url')->all();
            $sliderImages[$product->slug] = [
                'name' => $product->name,
                'slug' => $product->slug,
                'category_slug' => $product->category->slug,
                'price' => $product->price,
                'images' => array_slice($allImages, 0, 10)
            ];
        }
        
        foreach ($manufacturesProducts as $product) {
            $allImages = $product->images->pluck('url')->all();
            $sliderImages[$product->slug] = [
                'name' => $product->name,
                'slug' => $product->slug,
                'manufacturer_slug' => $product->manufacturer->slug,
                'price' => $product->price,
                'images' => array_slice($allImages, 0, 10)
            ];
        }

        foreach ($featuredArticles as $article) {
            $sliderImages[$article->slug] = [
                'title' => $article->title,
                'slug' => $article->slug,
                'topic_slug' => $article->topic->slug,
                'view' => $article->view,
                'images' => $article->image
            ];
        }
        
        foreach ($typesArticles as $article) {
            $sliderImages[$article->slug] = [
                'title' => $article->title,
                'slug' => $article->slug,
                'type_slug' => $article->ArticleType->slug,
                'view' => $article->view,
                'images' => $article->image
            ];
        }


        return view('frontend.home', compact('manufactures', 'categories', 'featuredProducts', 'manufacturesProducts', 'sliderImages', 'topics', 'article_types', 'featuredArticles', 'typesArticles'));
    }

    public function searchProducts(Request $request)
    {
        $keyword = $request->query('q');
        $query = Product::query();

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('description', 'LIKE', '%' . $keyword . '%');
            });

            $query->orWhereHas('category', function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%');
            });

            $query->orWhereHas('manufacturer', function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%');
            });
        } else {
            $products = collect();
        }
        $products = $query
            ->with(['category', 'manufacturer', 'images', 'details'])
            ->paginate(12)
            ->appends(['q' => $keyword]);

        $categories = Category::all();

        return view('frontend.products', [
            'products' => $products,
            'categories' => $categories,
            'search_keyword' => $keyword,
            'title' => 'Kết quả tìm kiếm cho: "' . $keyword . '"'
        ]);
    }


    public function getProductsCategories()
    {
        $query = Product::with(['category', 'manufacturer', 'avatar']);
        $category = null;
        $title = 'All Products';
        $products = $query->orderBy('name', 'asc')->get();
        $categories = Category::all();
        return view('frontend.products_categories', compact('products', 'category', 'categories', 'title'));
    }

    public function getProducts_Categories($categoryname_slug = '')
    {
        $query = Product::with(['category', 'manufacturer', 'avatar']);
        $category = null;
        if ($categoryname_slug) {
            $category = Category::where('slug', $categoryname_slug)->first();

            if ($category) {
                $query->where('category_id', $category->id);
                $title = $category->name . ' Products';
            } else {
                $title = 'Products Not Found';
            }
        } else {
            $title = 'All Products';
        }

        $products = $query->orderBy('name', 'asc')->get();

        $categories = Category::all();

        return view('frontend.products_categories', compact('products', 'category', 'categories', 'title'));
    }

    public function getProductManufacturer()
    {
        $query = Product::with(['category', 'manufacturer', 'avatar']);
        $manufacturer = null;
        $title = 'All Products';
        $products = $query->orderBy('name', 'asc')->get();
        $manufacturers = Manufacturer::all();
        return view('frontend.products_manufactures', compact('products', 'manufacturer', 'manufacturers', 'title'));
    }

    public function getProducts_Manufacturers($manufacturer_slug = '')
    {
        $query = Product::with(['category', 'manufacturer', 'avatar']);
        $manufacturer = null;
        if ($manufacturer_slug) {
            $manufacturer = Manufacturer::where('slug', $manufacturer_slug)->first();

            if ($manufacturer) {
                $query->where('manufacturer_id', $manufacturer->id);
                $title = $manufacturer->name . ' Products';
            } else {
                $title = 'Products Not Found';
            }
        } else {
            $title = 'All Products';
        }

        $products = $query->orderBy('name', 'asc')->get();

        $manufacturers = Manufacturer::all();

        return view('frontend.products_manufactures', compact('products', 'manufacturer', 'manufacturers', 'title'));
    }

    public function getProduct_Category($categoryname_slug = '', $productname_slug = '')
    {
        $product = Product::where('slug', $productname_slug)
            ->with(['category', 'manufacturer', 'details', 'images'])
            ->firstOrFail();

        $category = $product->category;

        $avatar = $product->images->where('is_avatar', true)->first();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('avatar')
            ->inRandomOrder()
            ->take(20)
            ->get();

        $title = $product->name;

        return view('frontend.product_category_details', compact('product', 'category', 'avatar', 'relatedProducts', 'title'));
    }

    public function getProduct_Manufacturer($manufacturer_slug = '', $productname_slug = '')
    {
        $product = Product::where('slug', $productname_slug)
            ->with(['category', 'manufacturer', 'details', 'images'])
            ->firstOrFail();

        $manufacturer = $product->manufacturer;
        $category = $product->category;

        $avatar = $product->images->where('is_avatar', true)->first();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('avatar')
            ->inRandomOrder()
            ->take(10)
            ->get();

        $title = $product->name;

        return view('frontend.product_manufacturer_details', compact('product', 'category', 'manufacturer', 'avatar', 'relatedProducts', 'title'));
    }

    public function getArticleTopics()
    {
        $query = Article::with(['topic', 'ArticleType', 'ArticleStatus', 'Comments']);
        $topic = null;
        $title = 'All Articles';
        $articles = $query->orderBy('title', 'asc')->get();
        $topics = Topic::all();
        return view('frontend.articles_topics', compact('articles', 'topic', 'topics', 'title'));
    }

    public function getArticleTypes()
    {
        $query = Article::with(['topic', 'ArticleType', 'ArticleStatus', 'Comments']);
        $article_type = null;
        $title = 'All Articles';
        $articles = $query->orderBy('title', 'asc')->get();
        $article_types = ArticleType::all();
        return view('frontend.articles_types', compact('articles', 'article_type', 'article_types', 'title'));
    }

    public function getArticles_Topics($topicname_slug = '')
    {
        $query = Article::with(['topic', 'ArticleType', 'ArticleStatus', 'Comments']);
        $topic = null;
        if ($topicname_slug) {
            $topic = Topic::where('slug', $topicname_slug)->first();

            if ($topic) {
                $query->where('topicid', $topic->id);
                $title = $topic->name . ' Articles';
            } else {
                $title = 'Articles Not Found';
            }
        } else {
            $title = 'All Articles';
        }

        $articles = $query->orderBy('title', 'asc')->get();

        $topics = Topic::all();

        return view('frontend.articles_topics', compact('articles', 'topic', 'topics', 'title'));
    }

    public function getArticles_Types($article_type_slug = '')
    {
        $query = Article::with(['topic', 'ArticleType', 'ArticleStatus', 'Comments']);
        $article_type = null;
        if ($article_type_slug) {
            $article_type = ArticleType::where('slug', $article_type_slug)->first();

            if ($article_type) {
                $query->where('articletypeid', $article_type->id);
                $title = $article_type->name . ' Articles';
            } else {
                $title = 'Articles Not Found';
            }
        } else {
            $title = 'All Articles';
        }

        $articles = $query->orderBy('title', 'asc')->get();

        $article_types = ArticleType::all();

        return view('frontend.articles_types', compact('articles', 'article_type', 'article_types', 'title'));
    }

    public function getArticle_Topic($topicname_slug = '', $title_slug = '')
    {
        $article = Article::where('slug', $title_slug)
            ->with(['Topic', 'ArticleType', 'ArticleStatus', 'Comments'])
            ->firstOrFail();

        $topic = $article->Topic;
        $avatar = $article->images;

        $relatedArticles = Article::where('topicid', $article->topicid) // Dùng topicid theo migration
            ->where('id', '!=', $article->id)
            ->where('is_enabled', 1)
            ->inRandomOrder()
            ->take(4) // Lấy 4 bài để giao diện cân đối
            ->get();

        $title = $article->title;
        return view('frontend.article_topic_details', compact('article', 'topic', 'relatedArticles', 'title'));
    }

    public function getArticle_Type($article_type_slug = '', $title_slug = '')
    {
        $article = Article::where('slug', $title_slug)
            ->with(['topic', 'ArticleType', 'ArticleStatus', 'Comments'])
            ->firstOrFail();

        $article_types = $article->ArticleType;

        $avatar = $article->images;

        $relatedArticles = Article::where('articletypeid', $article->articletypeid)
            ->where('id', '!=', $article->id)
            ->inRandomOrder()
            ->take(10)
            ->get();

        $title = $article->title;

        return view('frontend.article_type_details', compact('article', 'article_types', 'relatedArticles', 'title'));
    }

    public function getArticles($topicname_slug = '')
    {
        $topics = Topic::all();
        $article_types = ArticleType::all();

        $query = Article::where('is_enabled', 1)
            ->with(['Topic', 'ArticleType', 'User']);

        $topic = null;

        if (!empty($topicname_slug)) {
            $topic = Topic::where('slug', $topicname_slug)->firstOrFail();
            $query->where('topicid', $topic->id); // topicid khớp với migration
            $title = 'Topic: ' . $topic->name;
        } else {
            $title = 'IoT Knowledge Center';
        }

        $articles = $query->orderBy('created_at', 'desc')->get();

        return view('frontend.articles', compact(
            'title',
            'articles',
            'topics',
            'article_types',
            'topic'
        ));
    }


    public function getProducts()
    {
        //$manufactures = Manufacturer::orderBy('name')->get();
        $categories = Category::with([
            'products' => function ($query) {
                $query->latest()
                    ->with('avatar')
                    ->take(8);
            }
        ])->get();

        $manufactures = Manufacturer::with([
            'products' => function ($query) {
                $query->latest()
                    ->with('avatar')
                    ->take(8);
            }
        ])->get();

        $manufacturesProducts = Product::with(['images', 'manufacturer'])
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $featuredProducts = Product::with(['images', 'category'])
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $sliderImages = [];
        foreach ($featuredProducts as $product) {
            $allImages = $product->images->pluck('url')->all();
            $sliderImages[$product->slug] = [
                'name' => $product->name,
                'slug' => $product->slug,
                'category_slug' => $product->category->slug,
                'price' => $product->price,
                'images' => array_slice($allImages, 0, 10)
            ];
        }
        foreach ($manufacturesProducts as $product) {
            $allImages = $product->images->pluck('url')->all();
            $sliderImages[$product->slug] = [
                'name' => $product->name,
                'slug' => $product->slug,
                'manufacturer_slug' => $product->manufacturer->slug,
                'price' => $product->price,
                'images' => array_slice($allImages, 0, 10)
            ];
        }


        return view('frontend.products', compact('manufactures', 'categories', 'featuredProducts', 'manufacturesProducts', 'sliderImages'));
    }

    /*public function getArticle_Details($topicname_slug = '', $title_slug = '')
    {
        $title_id = explode('.', $title_slug);
        $title = explode('-', $title_id[0]);
        $article_id = $title[count($title) - 1];
        
        $article = Article::where('is_enabled', 1)
            ->where('is_approved', 1)
            ->where('id', $article_id)
            ->firstOrFail();
        
        if(!$article) abort(404);
        
        // Cập nhật lượt xem
        $daxem = 'ARTICLE' . $article_id;
        if(!session()->has($daxem))
        {
            $orm = Article::find($article_id);
            $orm->views = $orm->views + 1;
            $orm->save();
            session()->put($daxem, 1);
        }
        
        $relatedArticles = Article::where('is_enabled', 1)
            ->where('is_approved', 1)
            ->where('topicid', $article->topicid)
            ->where('id', '!=', $article->id)
            ->orderBy('created_at', 'desc')
            ->take(3)->get();

        return view('frontend.article_details', compact('article', 'relatedArticles'))
            ->where('is_enabled', 1)
            ->where('topicid', $article->topicid)
            ->where('id', '!=', $article->id)
            ->orderBy('created_at', 'desc')
            ->take(3)->get();
        
        return view('frontend.article_details', compact('article', 'relatedArticles'));
    }*/

    public function getShoppingCard()
    {
        if (Cart::count() > 0)
            return view('frontend.shoppingcard');
        else
            return view('frontend.shoppingcard');
    }

    public function getCard_Add($productname_slug = '')
    {
        $product = Product::where('slug', $productname_slug)
            ->with(['details', 'avatar'])
            ->first();

        if (!$product) {
            return redirect()->route('frontend.home')->with('error', 'The product does not exist..');
        }
        $details = $product->details;
        $image_url = optional($product->avatar)->url ?? 'product/default.png';

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'qty' => 1,
            'weight' => 0,
            'options' => [
                'memory' => optional($details)->memory,
                'cpu' => optional($details)->cpu,
                'graphic' => optional($details)->graphic,
                'power' => optional($details)->power_specs,
                'image' => $image_url,
            ]
        ]);

        return redirect()->route('frontend.home')->with('success', $product->name . ' đã được thêm vào giỏ hàng!');
    }

    public function getCard_Delete($row_id)
    {
        Cart::remove($row_id);
        return redirect()->route('frontend.shoppingcard');
    }

    public function getCard_Decrease($row_id)
    {
        $row = Cart::get($row_id);
        // Nếu số lượng là 1 thì không giảm được nữa
        if ($row->qty > 1) {
            Cart::update($row_id, $row->qty - 1);
        }
        return redirect()->route('frontend.shoppingcard');
    }

    public function getCard_Increase($row_id)
    {
        $row = Cart::get($row_id);
        // Không được tăng vượt quá 10 sản phẩm
        if ($row->qty < 10) {
            Cart::update($row_id, $row->qty + 1);
        }
        return redirect()->route('frontend.shoppingcard');
    }

    public function getRecruitment()
    {
        return view('frontend.recruitment');
    }

    public function getContact()
    {
        return view('frontend.contact');
    }

    public function getRegister()
    {
        return view('user.register');
    }

    public function getLogin()
    {
        return view('user.login');
    }
}
