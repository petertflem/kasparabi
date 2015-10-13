module.exports = function (grunt) {

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-copy');

	grunt.initConfig({
		less : {
			dev: {
				files: {
					'kbiwp/wp-content/themes/kasparabi/assets/css/custom.css': 'kbiwp/wp-content/themes/kasparabi/assets/less/main.less'
				}
			}
		},

		concat: {
			css: {
				src: ['kbiwp/wp-content/themes/kasparabi/assets/css/vendor/bootstrap.min.css', 'kbiwp/wp-content/themes/kasparabi/assets/css/custom.css'],
				dest: 'kbiwp/wp-content/themes/kasparabi/assets/css/main.css'
			}
		},

		clean: {
			css: ['kbiwp/wp-content/themes/kasparabi/assets/css/main.css'],
			temp: ['kbiwp/wp-content/themes/kasparabi/assets/css/custom.css'],
			build: ['build/**/*']
		},

		copy: {
			build: {
				files: [
					{ expand: true, dest: 'build/', src: [
						'kbiwp/wp-content/plugins/**/*',
						'kbiwp/wp-content/themes/kasparabi/**/*',
						'!**kbiwp/wp-content/themes/kasparabi/assets/less/**',
						'index.php'
					]}
				]
			}
		},

		delta: {
			options: {
				livereload: true
			},

			less: {
				files: 'kbiwp/wp-content/themes/kasparabi/assets/less/**/*.less',
				tasks: ['clean:css', 'less:dev', 'concat:css', 'clean:temp']
			},

			html: {
				files: '**/*.html'
			},

			php: {
				files: '../**/*.php'
			}
		}
	});

	grunt.renameTask('watch', 'delta');
	grunt.registerTask('watch', ['delta']);
	grunt.registerTask('compile_less', ['clean:css', 'less:dev', 'concat:css', 'clean:temp']);
	grunt.registerTask('build', ['clean:build', 'copy:build']);
}
