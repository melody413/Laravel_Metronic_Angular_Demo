import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HospitalTypeListComponent } from './hospital-type-list.component';

describe('HospitalTypeListComponent', () => {
  let component: HospitalTypeListComponent;
  let fixture: ComponentFixture<HospitalTypeListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [HospitalTypeListComponent]
    });
    fixture = TestBed.createComponent(HospitalTypeListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
