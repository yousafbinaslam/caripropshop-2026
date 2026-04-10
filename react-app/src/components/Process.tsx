import React from 'react';
import { motion } from 'framer-motion';
import { MessageCircle, Lightbulb, Palette, Hammer, CheckCircle } from 'lucide-react';

const Process: React.FC = () => {
  const steps = [
    {
      icon: MessageCircle,
      title: 'Initial Consultation',
      description: 'We start with a detailed discussion about your vision, needs, and budget.',
      duration: '1-2 weeks',
      details: ['Site visit and measurement', 'Lifestyle assessment', 'Budget planning', 'Timeline discussion']
    },
    {
      icon: Lightbulb,
      title: 'Concept Development',
      description: 'Our team creates initial design concepts and mood boards for your approval.',
      duration: '2-3 weeks',
      details: ['Mood board creation', 'Space planning', 'Initial 3D concepts', 'Material selection']
    },
    {
      icon: Palette,
      title: 'Design Development',
      description: 'Detailed design development with 3D visualizations and material specifications.',
      duration: '3-4 weeks',
      details: ['Detailed drawings', '3D renderings', 'Material boards', 'Lighting design']
    },
    {
      icon: Hammer,
      title: 'Implementation',
      description: 'Professional project management and execution of the design plan.',
      duration: '4-12 weeks',
      details: ['Vendor coordination', 'Quality control', 'Progress updates', 'Problem solving']
    },
    {
      icon: CheckCircle,
      title: 'Final Reveal',
      description: 'Project completion with final walkthrough and handover.',
      duration: '1 week',
      details: ['Final inspection', 'Touch-ups', 'Documentation', 'Maintenance guide']
    }
  ];

  return (
    <section id="process" className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Our Design Process
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            A proven methodology that ensures exceptional results from concept to completion. 
            We guide you through every step of your interior design journey.
          </p>
        </motion.div>

        <div className="relative">
          {/* Timeline Line */}
          <div className="hidden lg:block absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-amber-400 to-orange-500 rounded-full" />

          <div className="space-y-12 lg:space-y-24">
            {steps.map((step, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.8, delay: index * 0.2 }}
                viewport={{ once: true }}
                className={`flex flex-col lg:flex-row items-center gap-8 ${
                  index % 2 === 0 ? 'lg:flex-row' : 'lg:flex-row-reverse'
                }`}
              >
                {/* Content */}
                <div className="flex-1 lg:max-w-md">
                  <div className={`bg-gray-50 rounded-2xl p-8 ${
                    index % 2 === 0 ? 'lg:text-right' : 'lg:text-left'
                  }`}>
                    <div className={`flex items-center gap-4 mb-4 ${
                      index % 2 === 0 ? 'lg:justify-end' : 'lg:justify-start'
                    }`}>
                      <div className="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center">
                        <step.icon className="w-6 h-6 text-white" />
                      </div>
                      <div>
                        <h3 className="text-xl font-bold text-gray-900">{step.title}</h3>
                        <p className="text-amber-600 font-medium">{step.duration}</p>
                      </div>
                    </div>
                    
                    <p className="text-gray-700 mb-6">{step.description}</p>
                    
                    <div className="space-y-2">
                      {step.details.map((detail, detailIndex) => (
                        <div key={detailIndex} className={`flex items-center gap-2 ${
                          index % 2 === 0 ? 'lg:justify-end' : 'lg:justify-start'
                        }`}>
                          <div className="w-2 h-2 bg-amber-500 rounded-full" />
                          <span className="text-gray-600 text-sm">{detail}</span>
                        </div>
                      ))}
                    </div>
                  </div>
                </div>

                {/* Timeline Node */}
                <div className="hidden lg:block relative">
                  <div className="w-8 h-8 bg-white border-4 border-amber-500 rounded-full flex items-center justify-center">
                    <span className="text-amber-600 font-bold text-sm">{index + 1}</span>
                  </div>
                </div>

                {/* Spacer for alternating layout */}
                <div className="flex-1 lg:max-w-md" />
              </motion.div>
            ))}
          </div>
        </div>

        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="text-center mt-16"
        >
          <div className="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl p-8">
            <h3 className="text-2xl font-bold text-gray-900 mb-4">
              Ready to Start Your Design Journey?
            </h3>
            <p className="text-gray-600 mb-6">
              Let's discuss your project and create something extraordinary together.
            </p>
            <button
              onClick={() => {
                const element = document.getElementById('contact');
                if (element) element.scrollIntoView({ behavior: 'smooth' });
              }}
              className="px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-full hover:from-amber-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
            >
              Consult Now
            </button>
          </div>
        </motion.div>
      </div>
    </section>
  );
};

export default Process;