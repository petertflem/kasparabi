module.exports = function (grunt) {

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-clean');

	grunt.initConfig({
		less : {
			dev: {
				files: {
					'css/main.css': 'less/main.less'
				}
			}
		},

		clean: {
			css: ['css/main.css']
		},

		delta: {
			options: {
				livereload: true
			},

			less: {
				files: 'less/**/*.less',
				tasks: ['clean:css', 'less:dev']
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
}