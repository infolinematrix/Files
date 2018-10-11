<?php

namespace Reactor\Files\Console;


use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateMigrationCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'files:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the default Files migrations';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->comment(
            'Default migrations for Media, Directory and Substitute are going'
            . ' to be created in the database/migrations directory.'
        );
        $this->line('');

        foreach (['directories', 'media', 'substitutes'] as $table)
        {
            $this->info('Creating migration for ' . $table . '...');
            if ($this->createMigration($table))
            {
                $this->info('Migration successfully created!');
                $this->line('');
            } else
            {
                $this->error(
                    'Couldn\'t create migration.\n Check the write permissions' .
                    ' within the database/migrations directory.'
                );
            }
        }

        $this->promptMigrate();
    }

    /**
     * Creates migrations for tables
     *
     * @param string $table
     * @return bool
     */
    protected function createMigration($table)
    {
        $table = strtolower($table);

        $filepath = base_path() . '/database/migrations/' . date('Y_m_d_His') . '_FilesCreate' . studly_case($table) . 'Table.php';

        $output = view('_files::migrations.' . $table)->render();

        if ( ! file_exists($filepath))
        {
            $fs = fopen($filepath, 'x');
            if ($fs)
            {
                fwrite($fs, $output);
                fclose($fs);

                return true;
            } else
            {
                return false;
            }
        } else
        {
            return false;
        }
    }

    /**
     * Prompts for migration
     */
    protected function promptMigrate()
    {
        $this->line('');

        if ($this->confirm('Would you like to migrate database? [Yes|no]'))
        {
            $this->call('migrate');
        }
    }

}