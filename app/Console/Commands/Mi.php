<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Mi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mi {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'write migrations quickly. Format: tableName|columnType:column1,column2,column3|columnType:column4';
    
    /**
     * Migration file name
     * 
     * @var string
    */
    private $fileName       = "";
    
    /**
     * Migration table name
     * 
     * @var string
    */
    private $tableName      = "";
    
    /**
     * Migration Class name
     * 
     * @var string
    */
    private $className      = "";
    
    /**
     * Migration columns
     * 
     * @var string
    */
    private $columns        = "";
    
    /**
     * @own asset = migration architecture
     * 
     * @input = private vars
     * 
     * @return migration file data
    */
    private function blueprint()
    {
    
$blueprint = '<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class '.$this->className.' extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\''.$this->tableName.'\', function (Blueprint $table) {
            $table->increments(\'id\');
            $table->string(\'name\');'.$this->columns.'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(\''.$this->tableName.'\');
    }
}


';
        
        return $blueprint;
        
    }
    
    /**
     * writes file to disk
     * 
     * @arg $dir = directory to write file
     * 
     * @arg $contents = data to write in to file
     * 
     * @return void
    */
    private function file_write($dir, $contents)
    {
        $parts = explode('/', $dir);
        $file = array_pop($parts);
        $dir = '';
        foreach($parts as $part)
            if(!is_dir($dir .= "/$part")) mkdir($dir);
        file_put_contents("$dir/$file", $contents);
    }
    
    /**
     * Prepares migration data from $arguments
     * 
     * @arg $arguments = String with patterns
    */
    private function prepare($arguments)
    {
        
        $data = explode( '|', $arguments );
        
        $this->tableName = $data[0];
        
        $this->className = 'Create'.studly_case(strtolower( $this->tableName )).'Table';
        
        $this->fileName = date('Y_m_d_His')."_create_".strtolower($this->tableName)."_table";
        
        if( count( array_filter($data) ) > 1 )
        {
            
            array_shift($data);
            
            foreach($data as $list)
            {
                
                $type = explode(':', $list)[0];
                
                $columns = array_filter( explode( ',', explode(':', $list)[1] ) );
                
                switch( $type )
                {
                    
                    case 'foreign':
                        foreach( $columns as $column )
                        {
                            
                            $foreign_key    = explode('-', $column)[0];
                            $foreign_table  = explode('-', $column)[1];
                        
                            $this->columns .= '
            $table->integer(\''.$foreign_key.'\')->unsigned();
            $table->foreign(\''.$foreign_key.'\')->references(\'id\')->on(\''.$foreign_table.'\')->onDelete(\'cascade\');';
                
                        }
                        
                        break;
                        
                    case 'nullforeign':
                        foreach( $columns as $column )
                        {
                            
                            $foreign_key    = explode('-', $column)[0];
                            $foreign_table  = explode('-', $column)[1];
                        
                            $this->columns .= '
            $table->integer(\''.$foreign_key.'\')->unsigned()->nullable();
            $table->foreign(\''.$foreign_key.'\')->references(\'id\')->on(\''.$foreign_table.'\')->onDelete(\'set null\');';
                
                        }
                        break;
                        
                        default:
                            foreach( $columns as $column )
                            {
                                
                                $type = str_replace('tiny', 'tinyInteger', $type);
                                $type = str_replace('tinyIntegerInteger', 'tinyInteger', $type);
                                $type = str_replace('time', 'timestamp', $type);
                                $type = str_replace('timestampstamp', 'timestamp', $type);
                            
                                $this->columns .= '
            $table->'.$type.'(\''.$column.'\');';
                                
                            }
                            break;
                    
                    
                    
                }
                
                
            }
            
        }
        
        return $data;
        
    }
    
    /**
     * Write migration file to disk
     * 
     * @return void
    */ 
    private function make()
    {
        
        $file = database_path().'/migrations/'.$this->fileName.'.php';
        
        $content = $this->blueprint();
        
        $this->file_write( $file, $content );
        
    }
    

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $argument = $this->argument('data');
        
        $this->prepare( $argument );
        
        $this->make();
        
        $this->info( 'migration has been created : '. $this->fileName );
        
    }
    
    
    
    
}
