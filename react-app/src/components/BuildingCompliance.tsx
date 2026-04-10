import React from 'react';
import { motion } from 'framer-motion';
import { Building, CheckCircle, AlertTriangle, FileText, Shield, Clipboard } from 'lucide-react';

const BuildingCompliance: React.FC = () => {
  return (
    <div className="min-h-screen bg-gray-50 py-20">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="bg-white rounded-2xl shadow-lg p-8"
        >
          <div className="text-center mb-12">
            <Building className="w-16 h-16 text-amber-500 mx-auto mb-4" />
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Building Code Compliance</h1>
            <p className="text-gray-600">Ensuring all designs meet Indonesian building standards and regulations</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <Shield className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Regulatory Compliance Framework</h2>
              </div>
              <div className="bg-blue-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Indonesian Building Standards</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">National Standards (SNI)</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• SNI 03-1726-2019: Earthquake resistance design</li>
                      <li>• SNI 03-2847-2019: Structural concrete requirements</li>
                      <li>• SNI 03-1729-2020: Steel structure design</li>
                      <li>• SNI 03-6197-2011: Energy conservation standards</li>
                      <li>• SNI 03-7065-2005: Fire safety procedures</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Local Regulations</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Municipal building permits (IMB)</li>
                      <li>• Zoning compliance requirements</li>
                      <li>• Environmental impact assessments</li>
                      <li>• Heritage building restrictions</li>
                      <li>• Accessibility standards compliance</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <CheckCircle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Safety & Accessibility Standards</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-green-50 p-6 rounded-lg border border-green-200">
                  <h3 className="font-semibold text-gray-900 mb-3">Fire Safety Compliance</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Fire-resistant material specifications</li>
                    <li>• Emergency exit planning and signage</li>
                    <li>• Smoke detection and alarm systems</li>
                    <li>• Fire suppression system integration</li>
                    <li>• Evacuation route optimization</li>
                    <li>• Fire department access requirements</li>
                  </ul>
                </div>
                <div className="bg-purple-50 p-6 rounded-lg border border-purple-200">
                  <h3 className="font-semibold text-gray-900 mb-3">Accessibility Standards</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Wheelchair accessible entrances</li>
                    <li>• Ramp specifications and gradients</li>
                    <li>• Accessible bathroom facilities</li>
                    <li>• Elevator and lift requirements</li>
                    <li>• Visual and auditory assistance systems</li>
                    <li>• Parking space allocations</li>
                  </ul>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <FileText className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Permit & Documentation Process</h2>
              </div>
              <div className="bg-gradient-to-r from-orange-50 to-red-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Required Documentation</h3>
                <div className="grid md:grid-cols-3 gap-4">
                  {[
                    {
                      phase: 'Pre-Design',
                      documents: ['Site survey reports', 'Soil investigation', 'Zoning verification', 'Environmental clearance'],
                      color: 'blue'
                    },
                    {
                      phase: 'Design Phase',
                      documents: ['Architectural drawings', 'Structural calculations', 'MEP specifications', 'Fire safety plans'],
                      color: 'green'
                    },
                    {
                      phase: 'Construction',
                      documents: ['Building permits', 'Work safety plans', 'Material certifications', 'Progress inspections'],
                      color: 'purple'
                    }
                  ].map((phase, index) => (
                    <div key={index} className={`bg-${phase.color}-50 p-4 rounded-lg border border-${phase.color}-200`}>
                      <h4 className="font-medium text-gray-900 mb-2">{phase.phase}</h4>
                      <ul className="space-y-1">
                        {phase.documents.map((doc, i) => (
                          <li key={i} className="text-gray-700 text-xs flex items-center">
                            <CheckCircle className={`w-3 h-3 text-${phase.color}-600 mr-1`} />
                            {doc}
                          </li>
                        ))}
                      </ul>
                    </div>
                  ))}
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <AlertTriangle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Environmental & Sustainability Compliance</h2>
              </div>
              <div className="bg-green-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Environmental Standards</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• AMDAL (Environmental Impact Assessment)</li>
                      <li>• Waste management compliance</li>
                      <li>• Water conservation requirements</li>
                      <li>• Air quality standards</li>
                      <li>• Noise pollution control</li>
                      <li>• Green building certifications</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Energy Efficiency</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Building energy performance standards</li>
                      <li>• HVAC efficiency requirements</li>
                      <li>• Lighting energy consumption limits</li>
                      <li>• Renewable energy integration</li>
                      <li>• Insulation and thermal performance</li>
                      <li>• Smart building technology compliance</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Clipboard className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Professional Certification & Licensing</h2>
              </div>
              <div className="bg-indigo-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Design Team Certifications</h3>
                    <div className="space-y-3">
                      <div className="bg-white p-3 rounded border">
                        <h4 className="font-medium text-gray-900">Principal Designer</h4>
                        <ul className="text-gray-700 text-sm mt-1">
                          <li>• Certified Interior Designer (IAI)</li>
                          <li>• Building Code Specialist</li>
                          <li>• Fire Safety Consultant</li>
                        </ul>
                      </div>
                      <div className="bg-white p-3 rounded border">
                        <h4 className="font-medium text-gray-900">Sustainability Director</h4>
                        <ul className="text-gray-700 text-sm mt-1">
                          <li>• Sustainable Design Specialist</li>
                          <li>• Environmental Compliance Officer</li>
                          <li>• Green Building Consultant</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Compliance Monitoring</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Regular code update training</li>
                      <li>• Annual certification renewals</li>
                      <li>• Continuing education requirements</li>
                      <li>• Industry standard updates</li>
                      <li>• Professional development programs</li>
                      <li>• Peer review and auditing</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Building className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Quality Assurance & Inspection</h2>
              </div>
              <div className="bg-yellow-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Inspection Schedule</h3>
                <div className="space-y-3">
                  {[
                    { stage: 'Foundation Inspection', timing: 'Before concrete pouring', requirements: 'Structural compliance verification' },
                    { stage: 'Framing Inspection', timing: 'After structural completion', requirements: 'Load-bearing capacity check' },
                    { stage: 'MEP Rough-in', timing: 'Before wall closure', requirements: 'Electrical, plumbing, HVAC systems' },
                    { stage: 'Fire Safety Inspection', timing: 'Before occupancy', requirements: 'Emergency systems testing' },
                    { stage: 'Final Inspection', timing: 'Project completion', requirements: 'Overall compliance certification' }
                  ].map((inspection, index) => (
                    <div key={index} className="bg-white p-4 rounded border flex justify-between items-center">
                      <div>
                        <h4 className="font-medium text-gray-900">{inspection.stage}</h4>
                        <p className="text-gray-600 text-sm">{inspection.requirements}</p>
                      </div>
                      <span className="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                        {inspection.timing}
                      </span>
                    </div>
                  ))}
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Compliance Support & Contact</h2>
              <div className="bg-amber-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  Our compliance team ensures all projects meet or exceed Indonesian building standards and regulations.
                </p>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Compliance Officer</h3>
                    <div className="space-y-1 text-gray-700 text-sm">
                      <p><strong>Name:</strong> Cari Prop Shop</p>
                      <p><strong>Email:</strong> compliance@caripropshop.com</p>
                      <p><strong>Phone:</strong> Available upon request</p>
                      <p><strong>License:</strong> IAI Certified Designer</p>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Services</h3>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Code compliance review</li>
                      <li>• Permit application assistance</li>
                      <li>• Inspection coordination</li>
                      <li>• Regulatory consultation</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default BuildingCompliance;