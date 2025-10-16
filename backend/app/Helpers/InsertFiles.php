<?PHP
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InsertFiles
{
    protected $directory;
    protected $req;
    protected $name;

    protected $isMultiple;
    protected $separator;

    protected $fileNames;
    protected $isReplace;

    protected $firstName;

    protected $isInputExist;

    function __construct(Request $req, string $nameInput, string $directory)
    {
        $this->directory    = $directory;
        $this->firstName    = "FILE_";
        $this->fileNames    = null;

        $this->isMultiple   = false;
        $this->separator    = ',';
        $this->name         = $nameInput;

        $this->req          = $req;
        $this->isInputExist = $req->hasFile($nameInput);
    }

    function optional(bool $isMultiple = false, string $separator = ',')
    {
        $this->isMultiple   = $isMultiple;
        $this->separator    = $separator;

        return $this;
    }

    function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    function join($fileNames, bool $isReplace = false)
    {
        $this->fileNames = $fileNames;
        $this->isReplace = $isReplace;

        return $this;
    }

    function get()
    {
        if(!$this->isInputExist) 
        {
            return $this->fileNames != null ? $this->fileNames : null;
        }

        if($this->isMultiple)
        {
            $fileNames = [];

            if($this->isReplace && $this->fileNames != null)
            {
                $fileNames = explode($this->separator, $this->fileNames);
                foreach($fileNames as $fn) File::delete($this->directory . "\\" . $fn);

                $fileNames = [];
            }
            
            foreach($this->req->file($this->name) as $file)
            {
                $fileName = $this->firstName . time().rand(0, 1000);
                $fileName = $fileName.'.'.$file->getClientOriginalExtension();
                $file->move(public_path($this->directory), $fileName);
                $fileNames[] = $fileName;
            }

            return implode($this->separator, $fileNames);
        }
        else
        {
            if($this->isReplace && $this->fileNames != null)
            {
                File::delete($this->directory . "\\" . $this->fileNames);
            }

            $file     = $this->req->file($this->name);

            $fileName = $this->firstName . time().rand(0, 1000);
            $fileName = $fileName.'.'.$file->getClientOriginalExtension();

            $file->move(public_path($this->directory),$fileName);
            
            return $fileName;
        }

    }
}