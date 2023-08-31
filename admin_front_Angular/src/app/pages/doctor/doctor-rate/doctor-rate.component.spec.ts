import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DoctorRateComponent } from './doctor-rate.component';

describe('DoctorRateComponent', () => {
  let component: DoctorRateComponent;
  let fixture: ComponentFixture<DoctorRateComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [DoctorRateComponent]
    });
    fixture = TestBed.createComponent(DoctorRateComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
