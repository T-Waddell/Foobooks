<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use IanLChapman\PigLatinTranslator\Parser;
use App\Book;
class PracticeController extends Controller
{
    /*Remove any/all books by the author “J.K. Rowling”.
    */
    public function practice12()
    {
        $result = Book::where('author', '=', 'J.K. Rowling')->get();
        dump($result->toArray());
    }

    /*
        Retrieve all the books in descending order according to published date.
    */
    public function practice11()
    {
        $result = Book::where('published_year', '>', '1950')->orderBy('published_year', 'desc')->get();
        dump($result->toArray());
    }

    /*Retrieve all the books in alphabetical order by title.
    */
    public function practice10()
    {
        $result = Book::orderBy('title', 'asc')->get();
        dump($result->toArray());
    }

    /*
        Retrieve all the books published after 1950.
    */
    public function practice9()
    {
        $result = Book::where('published_year', '>', '1950')->get();
        dump($result->toArray());
    }

    /*Retrieve the last 2 books that were added to the books table.
    */
    public function practice8()
    {
        $result = Book::orderBy('created_at', 'desc')->limit(2)->get();
        dump($result->toArray());

        $book = new Book();
        #parameters: column we want to search, the constraint for that column, search term
        #The % around the search term are essentially wildcards
        $books = Book::orderBy('created_at', 'desc')->limit(2)->get();

        if ($books->isEmpty()) {
            dump('No matches found');
        } else {
            foreach ($books as $book) {
                dump($book->title);
            }
        }
    }

    public function practice7()
    {
        # First get a book to delete
        $book = Book::where('author', '=', 'F. Scott Fitzgerald')->first();

        if (!$book) {
            dump('Did not delete- Book not found.');
        } else {
            $book->delete();
            dump('Deletion complete; check the database to see if it worked...');
        }
    }

    public function practice6()
    {
        # First get a book to update
        $book = Book::where('author', '=', 'F. Scott Fitzgerald')->first();

        if (!$book) {
            dump("Book not found, can't update.");
        } else {
            # Change some properties
            $book->title = 'The Really Great Gatsby';
            $book->published_year = '2025';

            # Save the changes
            $book->save();

            dump('Update complete; check the database to confirm the update worked.');
        }
    }

    public function practice5()
    {
        $book = new Book();
        #parameters: column we want to search, the constraint for that column, search term
        #The % around the search term are essentially wildcards
        $books = $book->where('title', 'LIKE', '%Harry Potter%')->get();

        if ($books->isEmpty()) {
            dump('No matches found');
        } else {
            foreach ($books as $book) {
                dump($book->title);
            }
        }
    }

    public function practice4()
    {
        # Instantiate a new Book Model object
        $book = new Book();

        # Set the properties
        # Note how each property corresponds to a field in the table
        $book->title = 'Harry Potter and the Sorcerer\'s Stone';
        $book->author = 'J.K. Rowling';
        $book->published_year = 1997;
        $book->cover_url = 'http://prodimage.images-bn.com/pimages/9780590353427_p0_v1_s484x700.jpg';
        $book->purchase_url = 'http://www.barnesandnoble.com/w/harry-potter-and-the-sorcerers-stone-j-k-rowling/1100036321?ean=9780590353427';

        # Invoke the Eloquent `save` method to generate a new row in the
        # `books` table, with the above data (behind scenes it runs an sql command)
        $book->save();

        dump('Added: '.$book->title);
    }



    /**
     * Demonstrating using an external package
     */
    public function practice3()
    {
        $translator = new Parser();
        $translation = $translator->translate('Hello World');
        dump($translation);
    }
    /*
     * Demonstrating getting values from configs
     */
    public function practice2()
    {
        dump(config('mail.supportEmail'));
        # Disabling this line to prevent accidentally revealing mail related credentials on the prod. server
        //dump(config('mail'));
    }
    /**
     * Demonstrating the first practice example
     */
    public function practice1()
    {
        dump('This is the first example.');
    }
    /**
     * ANY (GET/POST/PUT/DELETE)
     * /practice/{n?}
     * This method accepts all requests to /practice/ and
     * invokes the appropriate method.
     * http://foobooks.loc/practice => Shows a listing of all practice routes
     * http://foobooks.loc/practice/1 => Invokes practice1
     * http://foobooks.loc/practice/5 => Invokes practice5
     * http://foobooks.loc/practice/999 => 404 not found
     */
    public function index($n = null)
    {
        $methods = [];
        # If no specific practice is specified, show index of all available methods
        if (is_null($n)) {
            # Build an array of all methods in this class that start with `practice`
            foreach (get_class_methods($this) as $method) {
                if (strstr($method, 'practice')) {
                    $methods[] = $method;
                }
            }
            # Load the view and pass it the array of methods
            return view('practice')->with(['methods' => $methods]);
        } # Otherwise, load the requested method
        else {
            $method = 'practice' . $n;
            # Invoke the requested method if it exists; if not, throw a 404 error
            return (method_exists($this, $method)) ? $this->$method() : abort(404);
        }
    }
}