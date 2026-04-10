import React from 'react';
import { motion } from 'framer-motion';
import { Award, Users, Clock, Heart, Phone, Mail, Palette, Lightbulb, Ruler, Camera, Wrench, TreePine } from 'lucide-react';

const About: React.FC = () => {
  const teamMembers = [
    {
      designation: 'Creative Director',
      specialization: 'Overall creative vision and strategy',
      icon: Lightbulb,
      color: 'purple',
      experience: '12+ Years'
    },
    {
      designation: 'Principal Interior Designer',
      specialization: 'Luxury residential and commercial spaces',
      icon: Palette,
      color: 'blue',
      experience: '10+ Years'
    },
    {
      designation: 'Senior Space Planner',
      specialization: 'Functional layout and flow optimization',
      icon: Ruler,
      color: 'green',
      experience: '8+ Years'
    },
    {
      designation: 'Sustainable Design Specialist',
      specialization: 'Eco-friendly and green building solutions',
      icon: TreePine,
      color: 'emerald',
      experience: '7+ Years'
    },
    {
      designation: '3D Visualization Artist',
      specialization: 'Photorealistic rendering and virtual tours',
      icon: Camera,
      color: 'pink',
      experience: '6+ Years'
    },
    {
      designation: 'Project Manager',
      specialization: 'Timeline coordination and client relations',
      icon: Clock,
      color: 'orange',
      experience: '9+ Years'
    },
    {
      designation: 'Lighting Design Consultant',
      specialization: 'Ambient and architectural lighting',
      icon: Lightbulb,
      color: 'yellow',
      experience: '8+ Years'
    },
    {
      designation: 'Materials & Finishes Coordinator',
      specialization: 'Sourcing and specification management',
      icon: Wrench,
      color: 'gray',
      experience: '5+ Years'
    },
    {
      designation: 'Junior Interior Designer',
      specialization: 'Residential design and client support',
      icon: Palette,
      color: 'indigo',
      experience: '3+ Years'
    },
    {
      designation: 'Design Assistant',
      specialization: 'CAD drafting and documentation',
      icon: Ruler,
      color: 'teal',
      experience: '2+ Years'
    }
  ];

  return (
    <section id="about" className="py-20 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Meet Our Creative Team
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            A passionate team of 10 creative professionals with diverse expertise, working together 
            to create extraordinary spaces that reflect our clients' personalities and exceed their expectations.
          </p>
        </motion.div>

        {/* Team Overview Stats */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="grid md:grid-cols-4 gap-6 mb-16"
        >
          <div className="bg-white rounded-xl p-6 text-center shadow-lg">
            <Users className="w-8 h-8 text-amber-500 mx-auto mb-3" />
            <div className="text-3xl font-bold text-gray-900 mb-2">10</div>
            <p className="text-gray-600">Creative Professionals</p>
          </div>
          <div className="bg-white rounded-xl p-6 text-center shadow-lg">
            <Award className="w-8 h-8 text-green-500 mx-auto mb-3" />
            <div className="text-3xl font-bold text-gray-900 mb-2">150+</div>
            <p className="text-gray-600">Projects Completed</p>
          </div>
          <div className="bg-white rounded-xl p-6 text-center shadow-lg">
            <Clock className="w-8 h-8 text-blue-500 mx-auto mb-3" />
            <div className="text-3xl font-bold text-gray-900 mb-2">65+</div>
            <p className="text-gray-600">Years Combined Experience</p>
          </div>
          <div className="bg-white rounded-xl p-6 text-center shadow-lg">
            <Heart className="w-8 h-8 text-red-500 mx-auto mb-3" />
            <div className="text-3xl font-bold text-gray-900 mb-2">98%</div>
            <p className="text-gray-600">Client Satisfaction</p>
          </div>
        </motion.div>

        {/* Team Members Grid */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-16"
        >
          {teamMembers.map((member, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: index * 0.1 }}
              viewport={{ once: true }}
              className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 group"
            >
              <div className={`w-16 h-16 bg-${member.color}-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform`}>
                <member.icon className={`w-8 h-8 text-${member.color}-600`} />
              </div>
              <h3 className="text-lg font-semibold text-gray-900 text-center mb-2">
                {member.designation}
              </h3>
              <p className="text-sm text-gray-600 text-center mb-3">
                {member.specialization}
              </p>
              <div className="text-center">
                <span className={`inline-block px-3 py-1 bg-${member.color}-50 text-${member.color}-700 text-xs font-medium rounded-full`}>
                  {member.experience}
                </span>
              </div>
            </motion.div>
          ))}
        </motion.div>

        {/* Contact Information */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="grid lg:grid-cols-2 gap-12 mb-16"
        >
          <div className="bg-white rounded-2xl p-8 shadow-lg">
            <h3 className="text-2xl font-bold text-gray-900 mb-6">Get in Touch with Our Team</h3>
            <div className="space-y-4">
              <div className="flex items-center">
                <Phone className="w-5 h-5 mr-3 text-amber-500" />
                <div>
                  <p className="font-medium text-gray-900">Main Office</p>
                  <p className="text-gray-600">+6282233039914</p>
                </div>
              </div>
              <div className="flex items-center">
                <Mail className="w-5 h-5 mr-3 text-amber-500" />
                <div>
                  <p className="font-medium text-gray-900">General Inquiries</p>
                  <p className="text-gray-600">info@caripropshop.com</p>
                </div>
              </div>
              <div className="flex items-center">
                <Mail className="w-5 h-5 mr-3 text-amber-500" />
                <div>
                  <p className="font-medium text-gray-900">Project Consultation</p>
                  <p className="text-gray-600">consult@caripropshop.com</p>
                </div>
              </div>
            </div>
          </div>

          <div className="bg-white rounded-2xl p-8 shadow-lg">
            <h3 className="text-2xl font-bold text-gray-900 mb-6">Our Expertise Areas</h3>
            <div className="grid grid-cols-2 gap-4">
              {[
                'Residential Design',
                'Commercial Spaces',
                'Hospitality Projects',
                'Sustainable Design',
                '3D Visualization',
                'Project Management',
                'Lighting Design',
                'Space Planning'
              ].map((expertise, index) => (
                <div key={index} className="flex items-center">
                  <div className="w-2 h-2 bg-amber-500 rounded-full mr-3" />
                  <span className="text-gray-700 text-sm">{expertise}</span>
                </div>
              ))}
            </div>
          </div>
        </motion.div>

        {/* Company Values */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="bg-white rounded-2xl p-8 shadow-lg"
        >
          <h3 className="text-3xl font-bold text-gray-900 text-center mb-8">Our Design Philosophy</h3>
          <div className="grid md:grid-cols-3 gap-8">
            {[
              {
                title: 'Collaborative Innovation',
                description: 'Our diverse team brings together unique perspectives to create groundbreaking design solutions.',
                icon: '🤝'
              },
              {
                title: 'Sustainable Excellence',
                description: 'We prioritize environmentally conscious designs that promote wellness and reduce environmental impact.',
                icon: '🌱'
              },
              {
                title: 'Client-Centric Approach',
                description: 'Every team member is dedicated to understanding and exceeding our clients\' expectations.',
                icon: '⭐'
              }
            ].map((value, index) => (
              <div key={index} className="text-center">
                <div className="text-4xl mb-4">{value.icon}</div>
                <h4 className="text-xl font-semibold text-gray-900 mb-3">{value.title}</h4>
                <p className="text-gray-600">{value.description}</p>
              </div>
            ))}
          </div>
        </motion.div>
      </div>
    </section>
  );
};

export default About;